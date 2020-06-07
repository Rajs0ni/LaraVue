<?php

namespace App\Sk\Todo;

use App\Sk\SkPayload;
use App\Sk\User\User;
use App\Sk\Todo\TodoPolicy;
use App\Sk\Todo\TodoValidation;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    static $policyClass = TodoPolicy::class;

    protected $fillable = ['title', 'notes', 'completion_date', 'is_completed'];

    function user()
    {
        return $this->belongsTo('App\Sk\User\User');
    }

    function doCreate(User $user, SkPayload $data)
    {
        (new TodoValidation($data))->validateCreate();
        // Check if todo already exist with the same name
        if (
            $user
                ->todos()
                ->where('title', $data->title)
                ->exists()
        ) {
            throw new SkException(
                trans('sk.todo/todo_already_exists', [
                    'title' => $data->title
                ])
            );
        }
        return $user->todos()->create((array) $data);
    }

    function doUpdate(SkPayload $data)
    {
        (new TodoValidation($data))->validateUpdate();
        $this->update((array) $data);
        return $this;
    }
}
