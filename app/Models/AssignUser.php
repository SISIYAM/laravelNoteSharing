<?php

namespace App\Models;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignUser extends Model
{
    use HasFactory;

    // assign table name because I forgot to create a table using assign_users
    protected $table = 'assign_user';

    protected $fillable = [
        'user_id',
        'department_id',
        
    ];

    public function getUser(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function getDepartment(){
        return $this->belongsTo(Department::class,'department_id','id');
    }
}
