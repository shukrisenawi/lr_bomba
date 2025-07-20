<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyAnswer extends Model
{
    protected $fillable = ['response_id', 'question_id', 'answer', 'value', 'score'];

    public function response(): BelongsTo
    {
        return $this->belongsTo(SurveyResponse::class, 'response_id');
    }
}
