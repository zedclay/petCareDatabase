<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetSupplier extends Model
{
    use HasFactory;
    protected $table = 'pet_suppliers';

    protected $fillable = [
        'pet_house',
        'address',
        'contact',
        'website',
        'photo',
    ];

    public function reviews()
    {
        return $this->hasMany(PetSupplierReview::class, 'reviewee_id');
    }

}
