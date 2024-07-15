<?php

namespace App\Models;

use App\Models\Semister;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function semisters()
    {
        return $this->hasMany(Semister::class, 'university_id', 'id');
    }

}