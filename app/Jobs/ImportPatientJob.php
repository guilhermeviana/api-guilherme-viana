<?php

namespace App\Jobs;

use App\Services\Address\StoreAddressService;
use App\Services\Patient\StorePatientService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ImportPatientJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function handle()
    {
        $file = storage_path('app/' . $this->path);
        $line = 0;

        $handle = fopen($file, 'r');

        while (($data = fgetcsv($handle)) !== false) {
            $line++;
            if ($line === 1) {
                continue;
            }

            try {
                DB::beginTransaction();
                $patient = app(StorePatientService::class)->execute([
                    'name' => $data[0],
                    'mother_name' => $data[1],
                    'birth' => Carbon::createFromFormat('Y-m-d', $data[2]),
                    'cpf' => $data[3],
                    'cns' => $data[4],
                ]);

                app(StoreAddressService::class)->execute([
                    'zip_code' => $data[5],
                    'street' => $data[6],
                    'number' => $data[7],
                    'complement' => $data[8],
                    'neighborhood' => $data[9],
                    'city' => $data[10],
                    'state' => $data[11],
                    'patient_id' => $patient->id,
                ]);

                DB::commit();
            } catch (Throwable $th) {
                DB::rollBack();
                Log::error($th);
            }
        }

        fclose($handle);
        unlink($file);
    }
}
