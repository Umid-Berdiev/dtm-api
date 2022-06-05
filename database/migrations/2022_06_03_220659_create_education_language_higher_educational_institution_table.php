<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationLanguageHigherEducationalInstitutionTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('education_language_higher_educational_institution', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('higher_educational_institution_id');
      $table->unsignedBigInteger('education_language_id');
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
    Schema::dropIfExists('education_language_higher_educational_institution');
  }
}
