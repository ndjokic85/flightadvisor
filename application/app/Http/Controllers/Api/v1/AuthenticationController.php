<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\AuthenticationPostRequest;
use App\Repositories\IUserRepository;

class AuthenticationController extends Controller
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(AuthenticationPostRequest $request)
    {
        $this->userRepository->create($request->validated());
    }
}
