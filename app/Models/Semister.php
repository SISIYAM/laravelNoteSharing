<?php

namespace App\Models;

use App\Models\Universitie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semister extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'semister_name',
        'status',
        'author',
    ];

    public function university()
    {
        return $this->belongsTo(Universitie::class, 'university_id', 'id');
    }
}