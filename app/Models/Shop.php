<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $primaryKey = 'shop_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'shop_id',
        'shop_name',
        'location_id',
        'address',
        'phone_number',
        'email',
        'description',
        'shop_image',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'shop_id', 'shop_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }
}
