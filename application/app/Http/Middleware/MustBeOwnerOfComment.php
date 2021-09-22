<?php

namespace App\Http\Middleware;

use App\Models\Comment;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MustBeOwnerOfComment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $route = Route::getRoutes()->match($request);
        $id = $route->parameter('comment');
        $comment = Comment::findOrFail($id);
        if (Auth::user()->hasRole('admin') || Auth::id() == $comment->user_id) {
            return $next($request);
        }
        return response(['message' => 'Unauthorized'], 401);
    }
}
