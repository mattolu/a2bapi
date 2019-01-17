<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\PasswordDriverReset;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordInterface;


class Driver extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordInterface
{
    use Authenticatable, CanResetPasswordTrait, Notifiable, Authorizable;
    //protected $guard = 'driver';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email','phone_no','address', 'flag', 'profile_pix'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
    ];

    /**
     * A driver can have many reports
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports() 
    {
        // return $this->hasMany('App\Report');
        return $this->hasMany(Report::class);
    }

    public function bus() 
    {
        return $this->hasOne(Bus::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function sendPasswordResetNotification($token)
  {
      $this->notify(new PasswordDriverReset($token));
  }
}
