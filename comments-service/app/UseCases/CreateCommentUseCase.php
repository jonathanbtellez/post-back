<?php

namespace App\UseCases;

use App\Models\Comment;

class CreateCommentUseCase {
    /**
     * Create a new comment.
     *
     * @param array $data
     * @return Comment
     */
    public function execute(array $data) {
        return Comment::create($data);
    }
}