<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;
class insertCourseTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //trigger on add new course
        DB::unprepared('CREATE TRIGGER insert_course_trigger AFTER INSERT ON `courses` FOR EACH ROW
                BEGIN
                   UPDATE `categories` SET courses_count = (courses_count+1)
                   WHERE id = NEW.category_id;
                END');

        //trigger on delete course
        DB::unprepared('CREATE TRIGGER delete_course_trigger AFTER DELETE ON `courses` FOR EACH ROW
                BEGIN
                   UPDATE `categories` SET courses_count = (courses_count-1)
                   WHERE id = OLD.category_id;

                END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `insert_course_trigger`');

        DB::unprepared('DROP TRIGGER `delete_course_trigger`');

    }
}
