<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamPassScoresTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('exam_pass_scores', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('hei_id');
      $table->unsignedBigInteger('direction_id')->nullable();
      $table->year('year');
      $table->unsignedDecimal('grant', 5, 2);
      $table->unsignedDecimal('contract', 5, 2);
      $table->enum('status', ['down', 'up', 'stable'])->default('stable');
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
    Schema::dropIfExists('exam_pass_scores');
  }
}
