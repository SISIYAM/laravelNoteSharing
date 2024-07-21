<?php

namespace App\Models;

use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;

class Pdf extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable =[
        'material_id',
        'title',
        'pdf',
        'author',
        'role',
    ];

    // method for generate slug
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

}