<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bus_product_name', 'bus_plate_no', 'driver_id',
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