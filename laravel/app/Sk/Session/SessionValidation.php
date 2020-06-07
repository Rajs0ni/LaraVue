<?php
namespace App\Sk\Session;

use App\Sk\SkPayload;
use App\Sk\SkValidation;

class SessionValidation extends SkValidation
{
    /**
     * fields
     */
    const FIELD_KEY = 'key';
    const FIELD_SECRET = 'secret';
    const FIELD_EMAIL = 'email';
    const FIELD_USER_ID = 'user_id';
    const FIELD_OTP = 'otp';
    const FIELD_IP_ADDRESS = 'ip_address';
    const FIELD_PLATFORM_SIGNATURE = 'platform_signature';

    function __construct(SkPayload $data)
    {
        $this->data = $data;

        $this->rules = [
            self::FIELD_KEY => 'required|string|exists:sessions,key',
            self::FIELD_USER_ID => 'required|numeric|exists:users,id',
            self::FIELD_IP_ADDRESS => 'required|string',
            self::FIELD_PLATFORM_SIGNATURE => 'required|string',
            self::FIELD_EMAIL => 'required|email|exists:users,email',
            self::FIELD_OTP => 'required|numeric'
        ];
    }

    function validateCreate()
    {
        $fields = [
            self::FIELD_EMAIL,
            self::FIELD_IP_ADDRESS,
            self::FIELD_PLATFORM_SIGNATURE
        ];

        $this->validate($fields);
    }

    function validateVerifyOtp()
    {
        $fields = [self::FIELD_KEY, self::FIELD_OTP];
        $this->validate($fields);
    }
}
