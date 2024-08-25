<?php

namespace App\Models;

use App\Models\Universitie;
use App\Models\Semister;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Department extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable =[
        'university_id',
        'department',
        'status',
        'author',
    ];

    // method for generate slug
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'department'
            ]
        ];
    }

    // relation with university table
    public function getUniversity(){
        return $this->belongsTo(Universitie::class,'university_id','id');
    }

    // relation with semesters table
    public function getSemesters(){
        return $this->hasMany(Semister::class,'department_id','id');
    }

    // relation with users table
    public function getAuthor(){
        return $this->belongsTo(User::class,'author','id');
    }
    
}
