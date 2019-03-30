<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysCourseAppointmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_appointment', function (Blueprint $table) {
            $table->foreign('room_id')
                ->references('id')
                ->on('room')
                ->onDelete('cascade');

            $table->foreign('course_id')
                ->references('id')
                ->on('course')
                ->onDelete('cascade');

            $table->foreign('time_slot_id')
                ->references('id')
                ->on('time_slot')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_appointment', function (Blueprint $table) {
            //
        });
    }
}
