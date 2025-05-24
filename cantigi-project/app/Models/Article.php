<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'publish_date',
        'author_id'
    ];

    public function employees() {
        return $this->belongsTo(Employee::class, 'author_id');
    }
}
