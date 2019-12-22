<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentFollowTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_follow_teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id')->default(0)->comment('学生ID');
            $table->unsignedInteger('teacher_id')->default(0)->comment('老师ID');
            $table->tinyInteger('status')->default(1)->comment('关注状态');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_follow_teachers');
    }
}
