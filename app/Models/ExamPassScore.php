<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamPassScore extends Model
{
  use HasFactory, SoftDeletes;

  protected $guarded = [];

  /**
   * Get the hei that owns the ExamPassScore
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function hei()
  {
    return $this->belongsTo(HigherEducationalInstitution::class);
  }
}
