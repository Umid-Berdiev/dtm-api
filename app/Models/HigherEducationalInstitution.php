<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HigherEducationalInstitution extends Model
{
  use HasFactory, SoftDeletes;

  protected $guarded = [];

  public function directions()
  {
    return $this->hasMany(Direction::class);
  }

  /**
   * Get the region that owns the HigherEducationalInstitution
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function region()
  {
    return $this->belongsTo(Region::class, 'region_soato', 'soato');
  }

  /**
   * Get all of the exam_pass_scores for the HigherEducationalInstitution
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function exam_pass_scores()
  {
    return $this->hasMany(ExamPassScore::class, 'hei_id');
  }

  /**
   * The education_forms that belong to the HigherEducationalInstitution
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function education_forms()
  {
    return $this->belongsToMany(
      EducationForm::class,
      'education_form_higher_educational_institution',
      'higher_educational_institution_id',
      'education_form_id'
    );
  }

  /**
   * The education_languages that belong to the HigherEducationalInstitution
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function education_languages()
  {
    return $this->belongsToMany(
      EducationLanguage::class,
      'education_language_higher_educational_institution',
      'higher_educational_institution_id',
      'education_language_id'
    );
  }

  /**
   * Get all of the ratings for the HigherEducationalInstitution
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function ratings()
  {
    return $this->hasMany(ExamPassScore::class, 'hei_id');
  }
}
