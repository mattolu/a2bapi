<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class User_subscription extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'tariff_plan', 'start_date', 'end_date', 'amount',
    ];

   /**
     * A user_sub belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
      return $this->belongsTo(User::class);
  }
}