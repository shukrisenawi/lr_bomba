<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section1 extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'email',
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
        'years_of_service',
        'service_status'
    ];
}
