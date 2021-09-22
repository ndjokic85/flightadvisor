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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    private IUserRepository $userRepository;

    private IRoleRepository $roleRepository;

    protected string $username;

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
        $user = DB::transaction(function () use ($attributes) {
            $roleIds = $this->roleRepository->findRoleIdsByName(Role::USER_ROLE);
            $user = $this->userRepository->create($attributes);
            $user->syncRoles($roleIds);
            return $user;
        });
        return UserResource::make($user->refresh())->response()->setStatusCode(201);
    }

    public function login(AuthenticationLoginRequest $request)
    {
        $user = $this->userRepository->findByUsername($request->username);
        if ($user && Hash::check($request->password, $user->password)) {
            return response([
                'data' => UserResource::make($user->refresh()),
                'token' => $user->createToken('auth-token')->plainTextToken
            ], 200);
        }

        return response(["message" => 'Credentials are invalid'], 401);
    }
}
