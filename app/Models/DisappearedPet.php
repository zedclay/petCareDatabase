<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisappearedPet extends Model
{
    use HasFactory;

    protected $table = 'disappeared_pets';

    protected $fillable = [
        'category',
        'name',
        'species',
        'sex',
        'photo',
        'user_id',
        'qr_code_text',
        'address',
        'phone_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
