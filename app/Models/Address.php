<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, UsesUuid, SoftDeletes;

    protected $fillable = [
        'zip_code',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'patient_id'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
