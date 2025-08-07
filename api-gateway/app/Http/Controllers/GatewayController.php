<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class GatewayController extends Controller
{
    public function postIndex(Request $request)
    {   
        $limit = $request->query('limit', 10);
        $response = Http::get('http://posts-service/api/posts?limit='.$limit);
        
        return response()->json([
            'data'    => $response->json()['data'],
            'message' => $response->json()['message'],
        ], $response->status());
    }

    public function postCreate(Request $request)
    {   
        $response = Http::post('http://posts-service/api/posts', $request->all());
        
        return response()->json([
            'message' => $response->json()['message'],
            'data'    => $response->json()['data'],
        ], $response->status());
    }
}
