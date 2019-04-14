<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleMaker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_maker', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->integer('room_id')->unsigned();
            $table->integer('time_slot_id')->unsigned();
            // Foreign keys.
            $table->foreign('course_id')
                  ->references('id')
                  ->on('course')
                  ->onDelete('cascade');
            $table->foreign('room_id')
                  ->references('id')
                  ->on('room')
                  ->onDelete('cascade');
            $table->foreign('time_slot_id')
                  ->references('id')
                  ->on('time_slot')
                  ->onDelete('cascade');
            
            $table->string('exam_date');
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
        Schema::dropIfExists('schedule_maker');
    }
}
