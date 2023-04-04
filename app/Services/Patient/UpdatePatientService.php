<?php

namespace App\Services\Patient;

use App\Models\Patient;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdatePatientService
{
    public function execute(Patient $patient, array $data)
    {
        try {
            return $patient->update(Arr::except($data, ['cpf']));
        } catch (Throwable $th) {
            Log::error($th);
        }
    }
}
