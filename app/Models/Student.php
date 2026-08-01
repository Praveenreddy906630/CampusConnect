<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';   // explicitly map to your table

    protected $primaryKey = 'id';

    public $timestamps = false; // since you use createdAt/updatedAt instead of Laravel default

    protected $fillable = [
        'enroll_no',
        'full_name',
        'program_code',
        'gender',
        'mobile',
        'email',
        'dept_code',
        'school_code',
        'school_name',
        'semester',
        'password',
        'is_tms',
        'createdAt',
        'updatedAt',
    ];
}
