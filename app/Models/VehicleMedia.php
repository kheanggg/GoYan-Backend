<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleMedia extends Model
{
    protected $table = 'vehicle_media';

    protected $fillable = [
        'vehicle_id',
        'media_type',
        'media_url',
        'description',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
