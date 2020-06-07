<?php

use App\Mail\OtpSent;
use App\Sk\User\User;
use App\Sk\SkException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

function generateOtp()
{
    if (App::environment(['local', 'test', 'stage', 'testing'])) {
        return 123456;
    } else {
        return rand(100000, 999999);
    }
}

function sendOtpToEmail(User $user, $otp)
{
    $email = $user->email;
    try {
        Mail::to($email)->send(new OtpSent($user->name, $otp));
    } catch (\Exception $e) {
        throw new SkException(trans('sk.user/otp_failed'));
    }
}

/**
 * Hash legitimate value
 */
function doHash($input)
{
    return !empty($input) ? hash('sha512', $input) : null;
}
