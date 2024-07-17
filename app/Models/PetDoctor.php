<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetDoctor extends Model
{
    use HasFactory;

    protected $table = 'pet_doctors';

    protected $fillable = [
        'name',
        'clinic_name',
        'address',
        'phone_number',
        'photo',
    ];

    public function reviews()
    {
        return $this->hasMany(PetDoctorReview::class, 'reviewee_id');
    }
}
