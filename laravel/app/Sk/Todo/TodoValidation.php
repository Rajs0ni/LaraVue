<?php

namespace App\Sk\Todo;

use App\Sk\SkValidation;

class TodoValidation extends SkValidation
{
    const FIELD_ID = 'id';
    const FIELD_TITLE = 'title';
    const FIELD_NOTES = 'notes';
    const FIELD_COMPLETION_DATE = 'completion_date';

    function __construct($data)
    {
        $this->data = $data;

        $this->rules = [
            self::FIELD_ID => 'required|numeric|exists:todos,id',
            self::FIELD_TITLE => 'required|string',
            self::FIELD_NOTES => 'nullable|string',
            self::FIELD_COMPLETION_DATE => 'required|date'
        ];
    }

    function validateCreate()
    {
        $fields = [self::FIELD_TITLE, self::FIELD_COMPLETION_DATE];
        $this->validate($fields);
    }

    function validateUpdate()
    {
        $fields = [
            self::FIELD_ID,
            self::FIELD_TITLE,
            self::FIELD_COMPLETION_DATE
        ];
        $this->validate($fields);
    }
}
