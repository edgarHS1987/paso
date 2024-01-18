<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverSchedule extends Model
{   
    protected $table = 'drivers_schedule';

    protected $fillable = [
        'drivers_id',   
        'date',
    ];
}
