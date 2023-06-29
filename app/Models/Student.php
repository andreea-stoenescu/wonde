<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'wonde_id',
        'school_id',
        'upi',
        'forename',
        'surname',
    ];

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(WClass::class, 'class_student', 'student_id', 'class_id');
    }
}
