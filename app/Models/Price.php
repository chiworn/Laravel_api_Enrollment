<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $table = 'tb_price';

    public $timestamps = false;

    protected $fillable = [
        'price_course',
        'created_at'
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'price_id', 'id');
    }
}
