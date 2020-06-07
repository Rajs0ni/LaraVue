<?php
namespace App\Sk;

use App\Sk\SkException;
use Illuminate\Support\Facades\Validator;

class SkValidation
{
    function validate($fields)
    {
        $applicableRules = [];
        foreach ($fields as $field) {
            $applicableRules[$field] = $this->rules[$field] ?? [];
        }
        if (count($applicableRules)) {
            $this->doValidation($applicableRules);
        }
    }

    protected function doValidation($rules)
    {
        $validator = Validator::make((array) $this->data, $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();

            $validation = [];
            foreach ($rules as $field => $rule) {
                if ($errors->has($field)) {
                    $validation[$field] = $errors->get($field);
                }
            }
            $e = new SkException(implode("\n", $errors->all()), 400);
            $e->validation = $validation;
            throw $e;
        }
    }
}
