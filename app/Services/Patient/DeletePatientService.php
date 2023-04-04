<?php

namespace App\Services\Patient;

use App\Models\Patient;
use Illuminate\Support\Facades\Log;
use Throwable;

class DeletePatientService
{
    public function execute(Patient $patient)
    {
        try {
            return $patient->forceDelete();
        } catch (Throwable $th) {
            Log::error($th);
        }
    }
}
