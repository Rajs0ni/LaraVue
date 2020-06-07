<?php

namespace App\Sk\Session;

use App\Sk\SkPayload;
use App\Sk\User\UserApi;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SessionApi
{
    /**
     * @return Session object
     */

    static function getInstance($key)
    {
        try {
            return Session::findOrFail($key);
        } catch (ModelNotFoundException $e) {
            throw new SkException(
                'Authorization invalid. Please login again.',
                419
            );
        }
    }

    static function authorize(SkPayload $payload)
    {
        return self::getInstance($payload->key)->authorize($payload);
    }

    static function authorizeByToken($tokenString)
    {
        $token = json_decode($tokenString);
        $payload = new SkPayload((array) $token);
        return self::authorize($payload);
    }

    static function create(SkPayload $payload)
    {
        $user = UserApi::findOrFailByEmail($payload->email);
        return (new Session())->doCreate($user, $payload);
    }

    static function verifyOtp(SkPayload $payload)
    {
        return self::getInstance($payload->key)->verifyOtp($payload);
    }

    static function logout(SkPayload $payload)
    {
        self::getInstance($payload->key)->delete();
    }
}
