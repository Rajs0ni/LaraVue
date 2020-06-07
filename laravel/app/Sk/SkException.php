<?php

namespace App\Sk;

use Exception;

class SkException extends Exception
{
    public $status = 500;

    public $message = '';
    public $title = 'Error !';
    public $remedy = 'Please Retry or Report to Support Team !';
    public $details = '';

    /**
     * throw exception based on type of exception
     */
    public static function throwException($message, $originalException)
    {
        if (!($originalException instanceof SkException)) {
            //change message
            if (config('app.debug')) {
                $message .= ' , Original:' . $originalException->message;
            }
            $originalException->message = $message;
        }

        throw $originalException;
    }
}
