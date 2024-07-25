<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Facultie extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'description',
        'image',
        'degree',
        'post',
        'status',
        'author',
    ];

    // method for generate slug
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
