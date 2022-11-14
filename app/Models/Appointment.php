<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'specialty'
    ];

    protected $hidden = [
        'id',
        'patient_id',
        'created_at',
        'updated_at'
    ];

    public function patient()
    {
        $this->belongsTo(Patient::class);
    }
}
