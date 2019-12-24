<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{

    use HasApiTokens;

    protected $guarded = ['id'];
    protected $hidden = ['password'];
    protected $primaryKey = 'id';

    public function follows()
    {
        return $this->hasMany(StudentFollowTeacher::class, 'student_id');
    }
}
