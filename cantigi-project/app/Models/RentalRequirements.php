<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalRequirements extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'resident_id_card',
        'work_or_student_id_card',
        'guarantee_type',
        'motorcycle_guarantee_doc',
        'deposit_amount',
        'social_media_link',
        'verified_by',
        'verified_at'
    ];

    public function customers() {
        return $this->belongsTo(Customer::class);
    }

    public function employees() {
        return $this->belongsTo(Employee::class);
    }
}
