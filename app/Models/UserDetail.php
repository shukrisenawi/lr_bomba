<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetail extends Model
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
        'location',
        'position',
        'state',
        'years_of_service',
        'service_status',
    ];
}
