<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\CityCommentPostRequest;
use App\Http\Resources\CommentResource;
use App\Repositories\ICityRepository;
use App\Repositories\ICommentRepository;
use Illuminate\Support\Facades\Auth;

class CityCommentController extends Controller
{
    private ICommentRepository $commentRepository;

    public function __construct(ICityRepository $cityRepository, ICommentRepository $commentRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->commentRepository = $commentRepository;
    }

    public function create(CityCommentPostRequest $request)
    {
        $attributes = $request->validated();
        $attributes['user_id'] = Auth::id();
        $city = $this->commentRepository->create($attributes);
        return CommentResource::make($city->refresh())->response()->setStatusCode(201);
    }
}
