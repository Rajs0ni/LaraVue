<?php

namespace App\Sk\User;

use App\Sk\SkPayload;
use App\Sk\SkException;
use App\Sk\User\UserValidation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    function doCreate(SkPayload $data)
    {
        try {
            (new UserValidation($data))->validateCreate();
            return $this->fill((array) $data)->save();
        } catch (\Exception $e) {
            SkException::throwException(trans('sk.user/creation_failed'), $e);
        }
    }

    function sendOtp($otp, $onMobile = false)
    {
        \sendOtpToEmail($this, $otp);
    }

    function markEmailVerified()
    {
        $this->email_verified = true;
        $this->save();
    }

    function todos()
    {
        return $this->hasMany('App\Sk\Todo\Todo');
    }
}
