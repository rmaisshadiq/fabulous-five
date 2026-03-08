<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusRoute extends Model
{
    protected $fillable = ['rute', 'kategori', 'min_hari'];

    public function prices(): HasMany
    {
        return $this->hasMany(BusRoutePrice::class);
    }
}
