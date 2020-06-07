<?php

namespace App\Sk\User;

use App\Sk\SkApi;
use App\Sk\SkPayload;
use App\Sk\User\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserApi extends SkApi
{
    static function getInstance($userId)
    {
        try {
            return User::findOrFail($userId);
        } catch (ModelNotFoundException $e) {
            throw new SkException(trans('sk.user/invalid_user'));
        }
    }

    static function register(SkPayload $payload)
    {
        return (new User())->doCreate($payload);
    }

    static function findOrFailByEmail($email)
    {
        try {
            return User::where('email', $email)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new SkException(trans('sk.user/please_register'));
        }
    }
}
