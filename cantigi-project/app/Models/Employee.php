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
        'name',
        'portrait',
        'position',
        'email',
        'phone',
        'hire_date',
        'status'
    ];
}
