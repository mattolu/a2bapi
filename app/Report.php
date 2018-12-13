<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'accident_address', 'accident_report', 'driver_id',
    ];

   /**
     * A report belongs to a driver
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function driver()
  {
      return $this->belongsTo('App\Driver');
  }
  
}