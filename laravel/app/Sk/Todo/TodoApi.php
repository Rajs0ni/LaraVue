<?php

namespace App\Sk\Todo;

use App\Sk\SkApi;
use App\Sk\SkPayload;
use App\Sk\Todo\Todo;
use App\Sk\SkException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TodoApi extends SkApi
{
    static function getInstance($todo_id)
    {
        try {
            return Todo::findOrFail($todo_id);
        } catch (ModelNotFoundException $e) {
            throw new SkException(trans('sk.todo/todo_not_found'));
        }
    }

    static function list(SkPayload $payload)
    {
        $user = SkApi::getLoggedIn()->user;
        if (!$user->can('list', Todo::class)) {
            throw new SkException(trans('sk.user/user_not_allowed_to_list'));
        }
        return $user->todos()->get();
    }

    static function get(SkPayload $payload)
    {
        $user = SkApi::getLoggedIn()->user;
        if (!$user->can('get', [Todo::class, $payload])) {
            throw new SkException(trans('sk.user/user_not_allowed_to_get'));
        }
        return self::getInstance($payload->id);
    }

    static function create(SkPayload $payload)
    {
        $user = SkApi::getLoggedIn()->user;
        if (!$user->can('create', Todo::class)) {
            throw new SkException(trans('sk.user/user_not_allowed_to_create'));
        }
        return (new Todo())->doCreate($user, $payload);
    }

    static function update(SkPayload $payload)
    {
        $user = SkApi::getLoggedIn()->user;
        if (!$user->can('update', [Todo::class, $payload])) {
            throw new SkException(trans('sk.user/user_not_allowed_to_update'));
        }
        return self::getInstance($payload->id)->doUpdate($payload);
    }

    static function delete(SkPayload $payload)
    {
        $user = SkApi::getLoggedIn()->user;
        if (!$user->can('delete', [Todo::class, $payload])) {
            throw new SkException(trans('sk.user/user_not_allowed_to_delete'));
        }
        return self::getInstance($payload->id)->delete();
    }
}
