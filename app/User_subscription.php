<?php

namespace App;


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
     * A report belongs to a driver
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
      return $this->belongsTo('App\User');
  }
}