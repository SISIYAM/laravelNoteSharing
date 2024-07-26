<?php

namespace App\Models;

use App\Models\User;
use App\Models\Material;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pdf extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable =[
        'material_id',
        'title',
        'pdf',
        'type',
        'author',
    ];

    // relation with materials table
    public function getMaterial(){
        return $this->belongsTo(Material::class,'material_id','id');
    }

    // relation with users table
    public function getAuthor(){
        return $this->belongsTo(User::class,'author','id');
    }

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