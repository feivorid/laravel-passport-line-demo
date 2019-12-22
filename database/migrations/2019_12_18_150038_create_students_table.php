<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->default('')->comment('用户昵称');
            $table->string('email', 100)->default('')->comment('email');
            $table->string('phone', 100)->default('')->comment('phone');
            $table->string('password', 100);
            $table->unsignedInteger('age')->default(0);
            $table->unsignedInteger('gender')->default(1);
            $table->boolean('enabled')->default(true);
            $table->text('intro')->nullable();
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
        Schema::dropIfExists('students');
    }
}
