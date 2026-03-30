<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'tb_students';

    // Disable standard timestamps if the table uses custom names like 'creat_at'
    public $timestamps = false; 

    protected $fillable = [
        'frist_name', // Database column with typo
        'last_name',
        'email_stu',
        'phone_num',
        'gender', // Included based on validation
        'creat_at'
    ];
}
