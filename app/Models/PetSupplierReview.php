<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetSupplierReview extends Model
{
    use HasFactory;
    protected $table = 'pet_supplier_reviews';

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
        return $this->belongsTo(PetSupplier::class, 'reviewee_id');
    }

}
