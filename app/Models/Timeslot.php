<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    use HasFactory;

    protected $table = 'tb_timeslot';

    public $timestamps = false;

    protected $fillable = [
        'start_time',
        'end_time',
        'created_at'
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'timeslot_id', 'id');
    }
}
