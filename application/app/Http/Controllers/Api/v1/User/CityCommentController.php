<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\CityCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\City;
use App\Models\Comment;
use App\Repositories\ICityRepository;
use App\Repositories\ICommentRepository;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CityCommentController extends Controller
{
    private ICommentRepository $commentRepository;

    public function __construct(ICityRepository $cityRepository, ICommentRepository $commentRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->commentRepository = $commentRepository;
    }

    public function create(CityCommentRequest $request, City $city)
    {
        $attributes = $request->validated();
        $attributes['user_id'] = Auth::id();
        $attributes['city_id'] = $city->id;
        $comment = $this->commentRepository->create($attributes);
        return CommentResource::make($comment->refresh())->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(CityCommentRequest $request, City $city, Comment $comment)
    {
        $this->commentRepository->update($comment->id, $request->validated());
        return CommentResource::make($comment->refresh())->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function delete(City $city, Comment $comment)
    {
        $this->commentRepository->delete($comment);
        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
