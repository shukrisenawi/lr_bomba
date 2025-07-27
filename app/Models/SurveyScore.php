<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyScore extends Model
{
    protected $fillable = ['response_id', 'section', 'score', 'category', 'recommendation'];

    protected $casts = [
        'score' => 'decimal:2',
    ];

    public function response(): BelongsTo
    {
        return $this->belongsTo(SurveyResponse::class);
    }
}
