<?php

namespace App\Models;

use App\Models\Department;
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
        'department_id',
    ];

    public function university()
    {
        return $this->belongsTo(Universitie::class, 'university_id', 'id');
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'semester_id', 'id');
    }

    // relation with department
    public function getDepartment(){
        return $this->belongsTo(Department::class,'department_id','id');
    }

}
