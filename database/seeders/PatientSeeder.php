<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::factory()
            ->count(5)
            ->hasAddress()
            ->create();

        $model = Patient::query()->create([
            'photo' => 'tmp/dummy.png',
            'name' => 'OM30',
            'mother_name' => 'Maria',
            'birth' => '2000-01-01',
            'cpf' => '81415296090',
            'cns' => '810213959300006',
        ]);

        Address::query()->create([
            'zip_code' => '04866200',
            'street' => 'Avenida Almeida',
            'number' =>  585,
            'complement' => 'CS',
            'neighborhood' => 'Jardim Almeida',
            'city' => 'São Paulo',
            'state' => 'SP',
            'patient_id' => $model->id
        ]);
    }
}
