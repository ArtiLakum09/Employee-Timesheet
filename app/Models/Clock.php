<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clock extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id', 'clock_in_time', 'clock_out_time', 'break_start_time','break_start_time'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
