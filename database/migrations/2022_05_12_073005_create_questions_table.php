<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subject_id');
            $table->enum('level', ['easy', 'middle', 'hard'])->default('easy');
            // $table->string('content');
            // $table->text('comment');
            $table->string('title_uz');
            $table->string('title_ru');
            $table->text('description_uz')->nullable();
            $table->text('description_ru')->nullable();
            $table->string('image_url_uz')->nullable();
            $table->string('image_url_ru')->nullable();
            $table->text('variant_1_uz');
            $table->text('variant_1_ru');
            $table->text('variant_2_uz');
            $table->text('variant_2_ru');
            $table->text('variant_3_uz');
            $table->text('variant_3_ru');
            $table->text('variant_4_uz');
            $table->text('variant_4_ru');
            $table->unsignedTinyInteger('correct_variant');
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
        Schema::dropIfExists('questions');
    }
}
