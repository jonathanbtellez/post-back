<?php

namespace App\UseCases;

use App\Http\Collections\PostCollection;
use App\Repositories\PostRepository;

class IndexPostUseCase
{

    public function __construct(private PostRepository $postRepository)
    {
    }

    public function execute($limit = 5)
    {
        return new PostCollection($this->postRepository->index($limit));
    }
}