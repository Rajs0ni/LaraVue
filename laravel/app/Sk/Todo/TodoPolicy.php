<?php

namespace App\Sk\Todo;

use App\Sk\SkPolicy;
use App\Sk\SkPayload;
use App\Sk\User\User;

class TodoPolicy extends SkPolicy
{
    function create(User $user)
    {
        return $user || false;
    }

    function list(User $user)
    {
        return $user || false;
    }

    function get(User $user, SkPayload $payload)
    {
        return $user->todos->contains($payload->id);
    }

    function update(User $user, SkPayload $payload)
    {
        return $user->todos->contains($payload->id);
    }

    function delete(User $user, SkPayload $payload)
    {
        return $user->todos->contains($payload->id);
    }
}
