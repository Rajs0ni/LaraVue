<?php

namespace App\Sk;

use Illuminate\Auth\Access\HandlesAuthorization;

class SkPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
