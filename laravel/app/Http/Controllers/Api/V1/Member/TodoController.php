<?php

namespace App\Http\Controllers\Api\V1\Member;

use App\Sk\SkPayload;
use App\Sk\Todo\TodoApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TodoController extends Controller
{
    function list(Request $request)
    {
        $result = ['message' => 'OK'];
        $payload = new SkPayload($request->all());
        $todos = TodoApi::list($payload);
        $result['todos'] = $todos;
        return response()->api($result);
    }

    function get(Request $request)
    {
        $result = ['message' => 'OK'];
        $payload = new SkPayload($request->all());
        $todo = TodoApi::get($payload);
        $result['todo'] = $todo;
        return response()->api($result);
    }

    function create(Request $request)
    {
        $result = ['message' => 'OK'];
        $payload = new SkPayload($request->all());
        $todo = TodoApi::create($payload);
        $result['todo'] = $todo;
        return response()->api($result);
    }

    function update(Request $request)
    {
        $result = ['message' => 'OK'];
        $payload = new SkPayload($request->all());
        $todo = TodoApi::update($payload);
        $result['todo'] = $todo;
        return response()->api($result);
    }

    function delete(Request $request)
    {
        $result = ['message' => 'OK'];
        $payload = new SkPayload($request->all());
        TodoApi::delete($payload);
        return response()->api($result);
    }
}
