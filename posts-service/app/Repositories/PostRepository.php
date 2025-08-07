<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PostRepository {

    /**
     * Save a post to the database.
     */
    public function save(Post $post): ?Post;

    /**
     * Find posts
     */
    public function index(int $limit): ?LengthAwarePaginator;
}