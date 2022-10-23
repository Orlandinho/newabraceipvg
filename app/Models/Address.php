<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'region',
        'city',
        'zipcode'
    ];

    protected $hidden = [
        'id',
        'patient_id',
        'created_at',
        'updated_at'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
