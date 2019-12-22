<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentFollowTeacher extends Model
{

    protected $guarded = ['id'];

    const STATUS = [
        1 => '已关注',
        0 => '已取消关注',
    ];

    const STATUS_ON = 1;
    const STATUS_OFF = -1;

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
