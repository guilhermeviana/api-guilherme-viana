<?php

namespace App\Services\Patient;

use App\Models\Patient;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Throwable;

class ListPatientService
{
    public function execute(array $filters)
    {
        try {
            return Patient::query()
                ->with('address')
                ->when(Arr::get($filters, 'name'), function ($query, $name) {
                    return $query->where('name', 'ilike', "%$name%");
                })
                ->when(Arr::get($filters, 'mother_name'), function ($query, $motherName) {
                    return $query->where('mother_name', 'ilike', "%$motherName%");
                })
                ->when(Arr::get($filters, 'cpf'), function ($query, $cpf) {
                    return $query->where('cpf', 'ilike', "%$cpf%");
                })
                ->when(Arr::get($filters, 'cns'), function ($query, $cns) {
                    return $query->where('cns', 'ilike', "%$cns%");
                })->when(Arr::get($filters, 'birth'), function ($query, $birth) {
                    return $query->whereDate('birth', $birth);
                })
                ->paginate(isset($filters['per_page']) ? $filters['per_page'] : 10);
        } catch (Throwable $th) {
            Log::error($th);
        }
    }
}
