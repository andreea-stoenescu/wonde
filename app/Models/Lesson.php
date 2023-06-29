<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'wonde_id',
        'wonde_room_id',
        'class_id',
        'employee_id',
        'start_at',
        'end_at',
    ];

    protected $dates = ['start_at', 'end_at'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(WClass::class, 'class_id');
    }
}
