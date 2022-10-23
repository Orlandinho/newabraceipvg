<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'dob'
    ];

    protected $hidden = [
        'dob',
        'create_at',
        'updated_at'
    ];

    protected $appends = [
        'birthday',
        'age'
    ];

    protected function age(): Attribute
    {
        return new Attribute(
            get: fn () => now()->diffInYears($this->dob)
        );
    }

    protected function birthday(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::createFromFormat('Y-m-d', $this->dob)->format('d/m/Y')
        );
    }

    public function address()
    {
        return $this->hasOne(Patient::class);
    }
}
