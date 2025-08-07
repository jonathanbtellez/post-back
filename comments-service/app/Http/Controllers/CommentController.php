<?php

namespace App\Http\Controllers;

use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'List of comments',
            'data' => Comment::paginate(10),
        ]);
    }

}
