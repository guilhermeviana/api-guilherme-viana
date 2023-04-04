<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, UsesUuid, SoftDeletes;

    protected $fillable = [
        'photo',
        'name',
        'mother_name',
        'birth',
        'cpf',
        'cns',
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
