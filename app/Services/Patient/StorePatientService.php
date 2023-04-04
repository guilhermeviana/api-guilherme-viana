<?php

namespace App\Services\Patient;

use App\Models\Patient;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class StorePatientService
{
    public function execute(array $data)
    {
        try {
            DB::beginTransaction();

            $photo = $data['photo'] ?? null;
            $patient = (new Patient())->fill(Arr::except($data, ['photo']));
            $this->handlePhoto($patient, $photo);
            $patient->save();

            DB::commit();
            return $patient;
        } catch (Throwable $th) {
            DB::rollBack();
            Log::error($th);
        }
    }

    private function handlePhoto(&$patient, $photo)
    {
        if ($photo instanceof UploadedFile) {
            $path = 'photos/' . Str::uuid()->toString() . '/' . $photo->getClientOriginalName();
            $photo->storeAs($path);
            $patient['photo'] = $path;
        } else {
            $patient->photo = null;
        }
    }
}
