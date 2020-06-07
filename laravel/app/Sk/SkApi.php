<?php
namespace App\Sk;

use App\Sk\SkException;
use App\Sk\Session\Session;

class SkApi
{
    static $loggedIn = null;

    static function setLoggedIn(Session $loggedIn)
    {
        SkApi::$loggedIn = $loggedIn;
    }

    static function getLoggedIn()
    {
        if (!SkApi::$loggedIn) {
            throw new SkException(trans('sk.session/logged_in_user_not_found'));
        }
        return SkApi::$loggedIn;
    }
}
