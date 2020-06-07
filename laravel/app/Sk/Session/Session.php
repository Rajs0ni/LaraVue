<?php

namespace App\Sk\Session;

use App\Sk\SkApi;
use App\Sk\SkPayload;
use App\Sk\User\User;
use App\Sk\SkException;
use Webpatser\Uuid\Uuid;
use App\Sk\Session\SessionValidation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'user_id',
        'otp',
        'ip_address',
        'platform',
        'platform_signature',
        'last_active_at',
        'mode'
    ];
    protected $hidden = [
        'otp',
        'secret',
        'created_at',
        'deleted_at',
        'updated_at',
        'user'
    ];
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'key';
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_active_at'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */

    public $incrementing = false;

    function getKeyAttribute()
    {
        return $this->attributes['key'] = empty($this->attributes['key'])
            ? (string) Uuid::generate()
            : $this->attributes['key'];
    }

    function getSecretAttribute()
    {
        return $this->attributes['secret'] = empty($this->attributes["secret"])
            ? crypt((string) Uuid::generate(), mt_rand())
            : $this->attributes["secret"];
    }

    function setOtpAttribute($value)
    {
        $this->attributes['otp'] = doHash($value);
    }

    function user()
    {
        return $this->belongsTo('App\Sk\User\User', 'user_id');
    }

    function authorize(SkPayload $data)
    {
        $toBeHashed = $data->key . $this->secret . $data->timestamp;
        $expected = hash('sha256', $toBeHashed);
        if ($data->hash != $expected) {
            throw new SkException(
                'Authorization invalid. Please login again.',
                419
            );
        }

        // Update last active time of the user in current session
        $this->updateLastActive();

        // Set user logged in
        $this->setLoggedIn();

        return $this;
    }

    function doCreate(User $user, SkPayload $data)
    {
        try {
            (new SessionValidation($data))->validateCreate();
            $data->key = $this->key;
            $data->otp = generateOtp();
            $data->user_id = $user->id;
            $this->fill((array) $data)->save();
            //send OTP (on mobile ?)
            $user->sendOtp($data->otp, $data->on_mobile ?? false);
            return $this;
        } catch (\Exception $e) {
            SkException::throwException(
                trans('sk.session/creation_failed'),
                $e
            );
        }
    }

    function verifyOtp(SkPayload $data)
    {
        try {
            (new SessionValidation($data))->validateVerifyOtp();
            if ($this->otp != doHash($data->otp)) {
                throw new SkException(trans('sk.session/invalid_otp'));
            }
            // Secret will be auto generated when reading it
            $this->secret;
            $this->otp = null;
            $this->last_active_at = now();
            $this->onboarding = 1;
            $this->save();

            //Also mark it logged in
            $this->setLoggedIn();

            return $this;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    function setLoggedIn()
    {
        // set the  session Entity
        SkApi::setLoggedIn($this);
    }

    function updateLastActive()
    {
        try {
            if ($this->last_active_at instanceof Carbon) {
                if ($this->last_active_at < now()->subSeconds(30)) {
                    $this->last_active_at = now();
                }
            } else {
                $this->last_active_at = now();
            }
            $this->save();
        } catch (\Exception $e) {
            SkException::throwException("Could not update last active", $e);
        }
    }
}
