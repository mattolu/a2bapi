<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordInterface;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordInterface
{
    use Authenticatable, CanResetPasswordTrait, Notifiable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'full_name', 'user_name', 'email', 'phone_number', 'profile_pix'
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
     * A user can have many reports
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports() 
    {
        return $this->hasMany(Report::class);
    }
    public function UserDestinationLocations() 
    {
        return $this->hasMany(UserDestinationLocation::class);
    }
    public function UserOriginLocations() 
    {
        return $this->hasMany(UserOriginLocation::class);
    }

    public function user_subscriptions() 
    {
        return $this->hasMany(User_subscription::class);
    }

    public function cards() 
    {
        return $this->hasMany(Card::class);
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
