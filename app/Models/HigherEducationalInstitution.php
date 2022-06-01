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
        return $this->hasMany(Examp::class, 'hei_id');
    }
}
