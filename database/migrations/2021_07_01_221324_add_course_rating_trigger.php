<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class AddCourseRatingTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //trigger on add rating of course
        DB::unprepared('CREATE TRIGGER add_course_ratting_trigger AFTER INSERT ON `course_rates` FOR EACH ROW
                BEGIN
                   UPDATE `courses` SET rating = (SELECT AVG(rating) FROM course_rates WHERE course_id= NEW.course_id)
                   WHERE id = NEW.course_id;
                END');

        //trigger on edit rating of course
        DB::unprepared('CREATE TRIGGER update_course_ratting_trigger AFTER UPDATE ON `course_rates` FOR EACH ROW
                BEGIN
                   UPDATE `courses` SET rating = (SELECT AVG(rating) FROM course_rates WHERE course_id= OLD.course_id)
                   WHERE id = OLD.course_id;
                END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `add_course_ratting_trigger`');
        DB::unprepared('DROP TRIGGER `update_course_ratting_trigger`');

    }
}
