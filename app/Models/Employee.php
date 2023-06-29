<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'wonde_id',
        'school_id',
        'legal_forename',
        'legal_surname',
        'upi',
    ];

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(WClass::class, 'class_employee', 'employee_id', 'class_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
