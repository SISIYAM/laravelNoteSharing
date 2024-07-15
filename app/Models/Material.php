<?php

namespace App\Models;

use App\Models\Semister;
use App\Models\Universitie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    public function university(){
        return $this->hasMany(Universitie::class);
    }

    public function semester(){
        return $this->hasMany(Semister::class);
    }
}