<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostRepositoryImpl implements PostRepository
{

    /**
     * Save a post to the database.
     */
    public function save(Post $post): ?Post
    {
        return $post->save() ? $post : null;
    }

    /**
     * Find posts
     */
    public function index(int $limit = 5): LengthAwarePaginator
    {
        return Post::paginate($limit);
    }
}