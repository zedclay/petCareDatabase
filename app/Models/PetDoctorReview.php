<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetDoctorReview extends Model
{
    use HasFactory;

    protected $table = 'pet_doctor_reviews';

    protected $fillable = [
        'rating',
        'reviewer_id',
        'reviewee_id',
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(PetDoctor::class, 'reviewee_id');
    }
}
