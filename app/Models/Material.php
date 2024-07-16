<?php

namespace App\Models;

use App\Models\Semister;
use App\Models\Universitie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    // public function getUniversity(){
    //     return $this->hasMany(Universitie::class,'id','university_id');
    // }

    // public function getSemester(){
    //     return $this->hasMany(Semister::class,'id','semester_id');
    // }

    public function getUniversity()
    {
        return $this->belongsTo(Universitie::class, 'university_id', 'id');
    }

    public function getSemester()
    {
        return $this->belongsTo(Semister::class, 'semester_id', 'id');
    }


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
}