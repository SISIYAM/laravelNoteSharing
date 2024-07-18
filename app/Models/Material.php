<?php

namespace App\Models;

use App\Models\Semister;
use App\Models\Universitie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;

class Material extends Model
{
    use HasFactory;
    use Sluggable;

    protected $casts = [
        'pdf' => 'json',
    ];
    protected $fillable = [
        'university_id',
        'semester_id',
        'title',
        'description',
        'pdf',
        'status',
        'author',
    ];


    public function getUniversity()
    {
        return $this->belongsTo(Universitie::class, 'university_id', 'id');
    }

    public function getSemester()
    {
        return $this->belongsTo(Semister::class, 'semester_id', 'id');
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
