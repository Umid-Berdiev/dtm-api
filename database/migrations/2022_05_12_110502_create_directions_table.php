<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('higher_educational_institution_id');
            $table->string('title_uz');
            $table->string('title_ru');
            $table->string('description_uz')->nullable();
            $table->string('description_ru')->nullable();
            $table->unsignedBigInteger('subject_1');
            $table->unsignedBigInteger('subject_2');
            // $table->unsignedBigInteger('subject_3');
            // $table->unsignedBigInteger('subject_4');
            // $table->unsignedBigInteger('subject_5');
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
        Schema::dropIfExists('directions');
    }
}
