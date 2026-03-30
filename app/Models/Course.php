<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'tb_course';

    // Uses ONLY created_at in original DB:: inserts
    public $timestamps = false;

    protected $fillable = [
        'course_name',
        'description',
        'duration_month',
        'created_at'
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id', 'id');
    }
}
