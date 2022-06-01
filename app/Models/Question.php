<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Get the subject that owns the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public static function getRandomData($subject_id, $locale, $level = 'easy', $count = 15)
    {
        $data = self::select([
            "id",
            "level",
            "title_$locale as title",
            "image_url_$locale as image_url",
            "variant_1_$locale as variant_1",
            "variant_2_$locale as variant_2",
            "variant_3_$locale as variant_3",
            "variant_4_$locale as variant_4"
        ])
            ->where('subject_id', $subject_id)
            ->where('level', $level)
            ->inRandomOrder()
            ->limit($count)
            ->get();

        return $data;
    }
}
