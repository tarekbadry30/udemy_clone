<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description');
            $table->integer('hours');
            $table->integer('rating')->default(0);
            $table->integer('views')->default(0);
            $table->integer('students')->default(0);
            $table->boolean('active')->default(true);
            $table->enum('level',['beginner','immediate','high']);
            $table->unsignedBigInteger('category_id');
            $table->foreign("category_id")->references("id")->on("categories")->onDelete('cascade')->onUpdate("cascade");
            $table->softDeletes();
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
        Schema::dropIfExists('courses');
    }
}
