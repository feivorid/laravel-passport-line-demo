<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $guarded = ['id'];
    protected $hidden = ['password'];

    public function teachers()
    {
        return $this->hasMany(StudentFollowTeacher::class, 'student_id');
    }
}
