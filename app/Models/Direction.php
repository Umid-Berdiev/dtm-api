<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Direction extends Model
{
  use HasFactory, SoftDeletes;

  protected $guarded = [];

  public function hei()
  {
    return $this->belongsTo(HigherEducationalInstitution::class);
  }

  public function first_subject()
  {
    return $this->hasOne(Subject::class, 'id', 'subject_1');
  }

  public function second_subject()
  {
    return $this->hasOne(Subject::class, 'id', 'subject_2');
  }
}
