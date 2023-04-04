<?php

namespace App\Services\Patient;

use App\Models\Patient;
use Illuminate\Support\Facades\Log;
use Throwable;

class ShowPatientService
{
    public function execute(Patient $patient)
    {
        try {
            return $patient->load('address');
        } catch (Throwable $th) {
            Log::error($th);
        }
    }
}
