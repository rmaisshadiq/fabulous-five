<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusRoutePrice extends Model
{
    protected $fillable = ['bus_route_id', 'tipe_bus', 'harga'];

    public function route(): BelongsTo
    {
        return $this->belongsTo(BusRoute::class, 'bus_route_id');
    }
}
