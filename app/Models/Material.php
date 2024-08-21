<?php

namespace App\Models;

use App\Models\Pdf;
use App\Models\Semister;
use App\Models\Universitie;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'university_id',
        'semester_id',
        'title',
        'description',
        'status',
        'author',
        'allocated',
    ];


    public function getUniversity()
    {
        return $this->belongsTo(Universitie::class, 'university_id', 'id');
    }

    public function getSemester()
    {
        return $this->belongsTo(Semister::class, 'semester_id', 'id');
    }

    public function getPdf(){
        return $this->hasMany(Pdf::class,'material_id','id');
    }

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
