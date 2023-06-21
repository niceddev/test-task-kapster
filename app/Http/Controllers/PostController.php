<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Enums\UserRole;
use App\Events\PostBlocked;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostToBlockRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Models\Post;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index(): ResourceCollection
    {
        return PostResource::collection(
            Post::where('blocked_at', null)->paginate()
        );
    }

    public function store(PostRequest $postRequest): JsonResponse
    {
        $validatedData = $postRequest->validated();

        $post = Post::create([
            ...$validatedData,
            'user_id'      => $postRequest->user()->id,
            'published_at' => $validatedData['published_at'] ?? now(),
        ]);

        if (!$post) {
            return (new ErrorResource([
                'message' => 'Something is wrong!',
                'code'    => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]))->response()->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return (new PostResource([
            'id' => $post->id,
            ...$validatedData,
        ]))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    public function update(PostRequest $postRequest, Post $post): PostResource
    {
        $validatedData = $postRequest->validated();
        $post->update($validatedData);

        return new PostResource($post);
    }

    public function block(PostToBlockRequest $postToBlockRequest, Post $post): PostResource|JsonResponse
    {
        $validatedData = $postToBlockRequest->validated();

        if ($postToBlockRequest->user()->role !== UserRole::MODERATOR->value) {
            return (new ErrorResource([
                'message' => 'Permission denied!',
                'code'    => Response::HTTP_FORBIDDEN,
            ]))->response()->setStatusCode(Response::HTTP_FORBIDDEN);
        }

        $post->update([
            'status' => PostStatus::BLOCKED->value,
            'blocked_at' => $validatedData['blocked_at'] ?? now(),
            'blocked_comment' => $validatedData['blocked_comment'],
        ]);

        PostBlocked::dispatch($post);

        return new PostResource($post);
    }

    public function getCurrentUsersPosts(): ResourceCollection
    {
        return PostResource::collection(
            Post::where('user_id', auth()->user()->id)->paginate()
        );
    }

    public function getRecentsUsersWithPosts(): ResourceCollection
    {
        return UserResource::collection(
            User::withCount('posts')
                ->with('recentPostsWithLimit')
                ->orderByDesc('posts_count')
                ->paginate()
        );
    }

}
