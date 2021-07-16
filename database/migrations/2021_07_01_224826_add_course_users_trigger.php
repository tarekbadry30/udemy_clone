<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCourseUsersTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //trigger on add new user to course
        DB::unprepared('CREATE TRIGGER add_course_users_trigger AFTER INSERT ON `course_users` FOR EACH ROW
                BEGIN
                   UPDATE `courses` SET students = (SELECT COUNT(id) FROM course_users WHERE course_id= NEW.course_id)
                   WHERE id = NEW.course_id;
                END');

        //trigger on remove user from course
        DB::unprepared('CREATE TRIGGER remove_course_users_trigger AFTER DELETE ON `course_users` FOR EACH ROW
                BEGIN
                   UPDATE `courses` SET students = (SELECT COUNT(id) FROM course_users WHERE course_id= OLD.course_id)
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
        DB::unprepared('DROP TRIGGER `add_course_users_trigger`');
        DB::unprepared('DROP TRIGGER `remove_course_users_trigger`');

    }
}
