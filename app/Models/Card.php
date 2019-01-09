<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'card_number', 'card_holder_name', 'expiry_month', 'expiry_year','cvv',
    ];

   /**
     * A card belongs to a User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
      return $this->belongsTo(User::class);
  }
  public function subscriptions() 
  {
      return $this->hasMany(User_subscription::class);
  }
}