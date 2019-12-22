<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasApiTokens;

    protected $guarded = ['id'];
    protected $hidden = ['password'];
    protected $primaryKey = 'id';

    public function students()
    {
        return $this->hasMany(StudentFollowTeacher::class, 'teacher_id');
    }

//    public function findForPassport($username)
//    {
//        return $this->where('email', $username)->first();
//    }
}
