<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
  use HasFactory, SoftDeletes;

  protected $guarded = [];
  protected $appends = [
    'correct_variant',
  ];

  public function getCorrectVariantAttribute()
  {
    return $this->question()->pluck('correct_variant')[0];
  }

  /**
   * Get the question that owns the Result
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function question()
  {
    return $this->belongsTo(Question::class);
  }

  /**
   * Get the exam that owns the Result
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function exam()
  {
    return $this->belongsTo(Exam::class);
  }

  /**
   * Get the subject that owns the Result
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function subject()
  {
    return $this->belongsTo(Subject::class);
  }
}
