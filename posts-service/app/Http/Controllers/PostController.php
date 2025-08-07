<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\UseCases\IndexPostUseCase;
use App\UseCases\CreatePostUseCase;
use App\UseCases\GetCommentsUseCase;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct(
        private IndexPostUseCase $indexPostUseCase,
        private CreatePostUseCase $createPostUseCase,
        private GetCommentsUseCase $getCommentsUseCase
    )
    {
    }

    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $response = $this->indexPostUseCase->execute($limit);
        
        return response()->json([
            'message' => 'Index of posts retrieved successfully',
            'data'    => $response->response()->getData(true),
        ]);
    }
    
    public function store(PostRequest $request)
    {
        try {
            $request->validated();
            
            $data     = $request->validated();
            $response = $this->createPostUseCase->execute($data);

            return response()->json([
                'message' => 'Post created successfully',
                'data'    => [
                    "uri" => "posts/$response->id"
                ],
            ], 201);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'An error occurred while creating the post',
                'data'    => ['errors' => $e->getMessage()],
            ], 500);
        }
    }

    public  function showComments(Request $request, $id)
    {
        $this->getCommentsUseCase->execute(['post_id' => $id]);

        return response()->json([
            'message' => 'Request to get comments for the post has been queued successfully',
            'data'    => [],
        ], 200);
    }
}