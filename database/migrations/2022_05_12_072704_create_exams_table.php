<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            // $table->bigInteger('direction_id');
            $table->string('title_uz');
            $table->string('title_ru');
            $table->string('comment_uz')->nullable();
            $table->string('comment_ru')->nullable();
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->unsignedBigInteger('hei_id')->nullable();
            $table->unsignedBigInteger('direction_id')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('exams');
    }
}
