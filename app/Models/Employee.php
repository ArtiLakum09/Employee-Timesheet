<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;
    protected $guard = 'employee';
    protected $fillable = ['employee_id', 'clock_in_time', 'clock_out_time', 'break_start_time','break_end_time', 'latitude', 'longitude'];

    public function clocks()
    {
        return $this->hasMany(Clock::class);

        
    }
}
