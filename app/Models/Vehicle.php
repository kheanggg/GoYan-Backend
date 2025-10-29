<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\VehicleMedia;
use App\Models\VehicleType;
use App\Models\Shop;

class Vehicle extends Model
{
    protected $table = 'vehicles';
    protected $primaryKey = 'vehicle_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'vehicle_id',
        'vehicle_type_id',
        'vehicle_name',
        'shop_id',
        'brand',
        'model',
        'year',
        'color',
        'rental_price_per_day',
        'description',
    ];

    public function media()
    {
        return $this->hasMany(VehicleMedia::class, 'vehicle_id', 'vehicle_id');
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id', 'vehicle_type_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'shop_id');
    }
}
