<?php

namespace App\Models;

use App\Models\Pdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'pdf_id',
        'rating',
        'name',
        'department',
        'batch',
        'review'
    ];

    public function getPdf(){
        return $this->belongsTo(Pdf::class,'pdf_id','id');
    }
}