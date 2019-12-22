<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = ['id'];
    protected $hidden = ['password'];

    public function students()
    {
        return $this->hasMany(StudentFollowTeacher::class, 'teacher_id');
    }
}
