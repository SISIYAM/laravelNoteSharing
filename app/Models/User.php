<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Pdf;
use App\Models\Facultie;
use App\Models\Semister;
use App\Models\AssignUser;
use App\Models\Department;
use App\Models\Universitie;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role',
        'last_login'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    

    public function materials()
    {
        return $this->hasMany(Material::class, 'author', 'id');
    }

    public function getAssigned(){
        return $this->hasMany(AssignUser::class,'user_id','id');
    }

    public function departments(){
        return $this->hasMany(Department::class,'author','id');
    }

    public function univerisity(){
        return $this->hasMany(Universitie::class,'author','id');
    }

    public function semester(){
        return $this->hasMany(Semister::class,'author','id');
    }

    public function pdf(){
        return $this->hasMany(Pdf::class,'author','id');
    }

    public function faculty(){
        return $this->hasMany(Facultie::class,'author','id');
    }
}