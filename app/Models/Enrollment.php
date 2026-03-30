<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $table = 'tb_enrollment';

    // The original DB:: insert uses created_at and updated_at
    public $timestamps = true;

    protected $fillable = [
        'course_id',
        'timeslot_id',
        'term_id',
        'price_id',
        'Frist_name', // Follow original case from controller
        'last_name',
        'phone',
        'email',
        'status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class, 'timeslot_id', 'id');
    }

    public function termslot()
    {
        return $this->belongsTo(Termslot::class, 'term_id', 'id'); // Maps to term_id despite table being tb_ternslot
    }

    public function price()
    {
        return $this->belongsTo(Price::class, 'price_id', 'id');
    }
}
