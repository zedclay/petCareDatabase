<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoundPet extends Model
{
    use HasFactory;
    protected $table = 'found_pets';

    protected $fillable = [
        'category',
        'species',
        'sex',
        'photo',
        'qr_code_text',
        'user_id',
        'address',
        'phone_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
