<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\AuthenticationLoginRequest;
use App\Http\Requests\Api\v1\AuthenticationPostRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Repositories\IRoleRepository;
use App\Repositories\IUserRepository;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    private IUserRepository $userRepository;

    private IRoleRepository $roleRepository;

    protected $username;

    public function __construct(IUserRepository $userRepository, IRoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->username = 'username';
    }

    public function username()
    {
        return $this->username;
    }

    public function create(AuthenticationPostRequest $request)
    {
        $attributes = $request->validated();
        $attributes['password'] = Hash::make($request->password);
        $user = $this->userRepository->create($attributes);
        $roleIds = $this->roleRepository->findRoleIdsByName(Role::USER_ROLE);
        $user->syncRoles($roleIds);
        $user->createToken('tokens')->plainTextToken;
        return UserResource::make($user->refresh())->response()->setStatusCode(201);
    }

    public function login(AuthenticationLoginRequest $request)
    {
        $user = User::where('username', $request->username)->first();
        if (Hash::check($request->password, $user->password)) {
            $user->createToken('tokens')->plainTextToken;
            return UserResource::make($user->refresh())->response()->setStatusCode(200);
        }
        return response(["message" => 'User does not exist'], 422);
    }
}
