<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universitie extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'semester',
        'status',
        'image',
        'author',
    ];
}