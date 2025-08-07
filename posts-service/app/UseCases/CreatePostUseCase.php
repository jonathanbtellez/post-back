<?php

namespace App\UseCases;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostRepository;


class CreatePostUseCase
{
    public function __construct(private PostRepository $postRepository)
    {
    }

    public function execute($data)
    {
        return new PostResource($this->postRepository->save(new Post($data)));
    }
}