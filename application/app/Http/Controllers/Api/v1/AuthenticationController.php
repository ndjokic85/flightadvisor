<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\AuthenticationPostRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use App\Repositories\IRoleRepository;
use App\Repositories\IUserRepository;

class AuthenticationController extends Controller
{
    private IUserRepository $userRepository;

    private IRoleRepository $roleRepository;

    public function __construct(IUserRepository $userRepository, IRoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function create(AuthenticationPostRequest $request)
    {
        $user = $this->userRepository->create($request->validated());
        $roleIds = $this->roleRepository->findRoleIdsByName(Role::USER_ROLE);
        $user->syncRoles($roleIds);
        return UserResource::make($user->refresh())->response()->setStatusCode(201);
    }
}
