<?php

namespace App\Sk\User;

use App\Sk\SkPayload;
use App\Sk\SkValidation;
use Illuminate\Validation\Rule;

class UserValidation extends SkValidation
{
    const FIELD_USER_ID = 'id';
    const FIELD_NAME = 'name';
    const FIELD_EMAIL = 'email';

    function __construct(SkPayload $data)
    {
        $this->data = $data;

        $this->rules = [
            self::FIELD_USER_ID => 'required|numeric|min:1',
            self::FIELD_NAME => 'required|string|min:3',
            self::FIELD_EMAIL => array(
                'required',
                Rule::unique('users')->ignore($data->id ?? 0)
            )
        ];
    }

    function validateCreate()
    {
        $fields = [self::FIELD_NAME, self::FIELD_EMAIL];
        $this->validate($fields);
    }
}
