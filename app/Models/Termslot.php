<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termslot extends Model
{
    use HasFactory;

    // Mapping to the typo tablename
    protected $table = 'tb_ternslot';

    public $timestamps = false;

    protected $fillable = [
        'tern_day', // Mapping to typo column in DB
        'created_at'
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'term_id', 'id');
    }
}
