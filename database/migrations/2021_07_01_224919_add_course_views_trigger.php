<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseViewsTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    //trigger on add new user to course
        DB::unprepared('CREATE TRIGGER add_course_views_trigger AFTER INSERT ON `course_views` FOR EACH ROW
                BEGIN
                   UPDATE `courses` SET views = views+1
                   WHERE id = NEW.course_id;
                END');    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `add_course_views_trigger`');
    }
}
