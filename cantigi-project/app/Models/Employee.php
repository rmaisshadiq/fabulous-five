<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    //
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'user_id',
        // 'portrait',
        'position',
        'phone',
        'hire_date',
        'status'
    ];

    public function article() {
        return $this->hasMany(Article::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function requirement() {
        return $this->hasMany(RentalRequirements::class);
    }

    public function verifiedUsers()
    {
        return $this->hasMany(RentalRequirements::class, 'verified_by');
    }
}
