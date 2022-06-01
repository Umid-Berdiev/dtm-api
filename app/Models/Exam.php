<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
  use HasFactory, SoftDeletes;

  protected $guarded = [];
  protected $appends = [
    // 'scores',
    'score_subject1',
    'score_subject2',
    'score_onatili',
    'score_matematika',
    'score_uzb_tarixi',
    'score_total',
  ];

  /**
   * Get the user that owns the Exam
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Get the hei associated with the Exam
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function hei()
  {
    return $this->belongsTo(HigherEducationalInstitution::class);
  }

  /**
   * Get the direction associated with the Exam
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function direction()
  {
    return $this->belongsTo(Direction::class);
  }

  /**
   * Get all of the results for the Exam
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function results()
  {
    return $this->hasMany(Result::class, 'exam_id');
  }

  public function getScoreSubject1Attribute()
  {
    $results = $this->results()->with('subject')->where('subject_slug', 'subject1')->get();
    $subject_title = '';
    $score = 0;

    foreach ($results as $result) {
      if ($result->user_variant === $result->correct_variant) {
        $score += 3.1;
      }
    }

    if (count($results) > 0) $subject_title = $results[0]['subject']["title_uz"];

    return ['score' => round($score, 2), 'subject_title' => $subject_title];
  }

  public function getScoreSubject2Attribute()
  {
    $results = $this->results()->with('subject')->where('subject_slug', 'subject2')->get();
    $subject_title = '';
    $score = 0;

    foreach ($results as $result) {
      if ($result->user_variant === $result->correct_variant) {
        $score += 2.1;
      }
    }

    if (count($results) > 0) $subject_title = $results[0]['subject']["title_uz"];

    return ['score' => round($score, 2), 'subject_title' => $subject_title];
  }

  public function getScoreOnatiliAttribute()
  {
    $results = $this->results()->where('subject_slug', 'onatili')->get();
    $score = 0;

    foreach ($results as $result) {
      if ($result->user_variant === $result->correct_variant) {
        $score += 1.1;
      }
    }

    return round($score, 2);
  }

  public function getScoreMatematikaAttribute()
  {
    $results = $this->results()->where('subject_slug', 'matematika')->get();
    $score = 0;

    foreach ($results as $result) {
      if ($result->user_variant === $result->correct_variant) {
        $score += 1.1;
      }
    }

    return round($score, 2);
  }

  public function getScoreUzbTarixiAttribute()
  {
    $results = $this->results()->where('subject_slug', 'uzb_tarixi')->get();
    $score = 0;

    foreach ($results as $result) {
      if ($result->user_variant === $result->correct_variant) {
        $score += 1.1;
      }
    }

    return round($score, 2);
  }

  public function getScoreTotalAttribute()
  {
    $total = $this->getScoreSubject1Attribute()['score'] +
      $this->getScoreSubject2Attribute()['score'] +
      $this->getScoreOnatiliAttribute() +
      $this->getScoreMatematikaAttribute() +
      $this->getScoreUzbTarixiAttribute();

    return round($total, 2);
  }

  public function getScoresAttribute()
  {
    $score1 = $this->results()
      ->where('subject_slug', 'subject1')
      ->select('correct_variant', 'user_variant');
    // $res_score1 = $score1->whereColumn('user_variant', 'correct_variant')->count();

    $score2 = $this->results()
      ->where('subject_slug', 'subject2')
      ->select('correct_variant', 'user_variant');
    // $res_score2 = $score2->whereColumn('user_variant', 'correct_variant')->count();


    $score3 = $this->results()
      ->where('subject_slug', 'onatili')
      ->select('correct_variant', 'user_variant');
    // $res_score3 = $score3->whereColumn('user_variant', 'correct_variant')->count();

    $score4 = $this->results()
      ->where('subject_slug', 'matematika')
      ->select('correct_variant', 'user_variant');
    // $res_score4 = $score4->whereColumn('user_variant', 'correct_variant')->count();

    $score5 = $this->results()
      ->where('subject_slug', 'uzb_tarixi')
      ->select('correct_variant', 'user_variant');
    // $res_score5 = $score5->whereColumn('user_variant', 'correct_variant')->count();

    return [
      'subject1' => $score1,
      'subject2' => $score2,
      'onatili' => $score3,
      'matematika' => $score4,
      'uzb_tarixi' => $score5,
    ];
  }
}
