<?php

namespace App\Http\Controllers\Api\V1\Guest;

use App\Sk\SkPayload;
use App\Sk\User\UserApi;
use Illuminate\Http\Request;
use App\Sk\Session\SessionApi;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    function register(Request $request)
    {
        $result = ['message' => 'OK'];
        $payload = new SkPayload($request->all());
        // Do the registration
        UserApi::register($payload);
        // Read client platform info
        $payload->_appendClientPlatformInfo($request);
        // Create user session
        $session = SessionApi::create($payload);
        $result['key'] = $session->key;
        // Return session key
        return response()->api($result);
    }

    function verify(Request $request)
    {
        $result = ['message' => 'OK'];
        $payload = new SkPayload($request->all());
        // Let's verify, and return the session secret
        $session = SessionApi::verifyOtp($payload);
        $result['secret'] = $session->secret;
        // return user & todo
        $user = UserApi::getInstance($session->user_id);
        $user->markEmailVerified();
        $result['user'] = $user;
        $result['todos'] = $user->todos()->get();
        return response()->api($result);
    }

    function login(Request $request)
    {
        $result = ['message' => 'OK'];
        $payload = new SkPayload($request->all());
        // Step-1::Read client platform info
        $payload->_appendClientPlatformInfo($request);
        // Step-2::Create user session
        $session = SessionApi::create($payload);
        $result['key'] = $session->key;
        return response()->api($result);
    }

    function logout(Request $request)
    {
        $result = ['message' => 'OK'];
        $payload = new SkPayload($request->all());
        SessionApi::logout($payload);
        return response()->api($result);
    }
}
