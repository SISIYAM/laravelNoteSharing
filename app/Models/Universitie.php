<?php

namespace App\Models;

use App\Models\Material;
use App\Models\Semister;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;

class Universitie extends Model
{
    use HasFactory;
    use Sluggable;

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

    public function material(){
        return $this->hasMany(Material::class,'university_id','id');
    }


    //method for generate slug
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}