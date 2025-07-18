<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'age',
        'place_of_birth',
        'gender',
        'ethnicity',
        'marital_status',
        'education_level',
        'monthly_income_self',
        'monthly_income_spouse',
        'other_income',
        'current_position',
        'grade',
        'location',
        'position',
        'state',
        'years_of_service',
        'service_status',
        'consent_given',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
