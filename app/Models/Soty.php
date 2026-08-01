<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soty extends Model
{
    protected $table = 'soty';

    protected $primaryKey = 'soty_id';  

    protected $fillable = [
        'enrolment_no',
        'even_attendance',
        'odd_attendance',
        'even_cgpa',
        'odd_cgpa',
        'details',
        'question',
        'file_location'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'enrolment_no', 'enroll_no');
    }
}
