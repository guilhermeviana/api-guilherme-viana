<?php

namespace App\Services\Address;

use App\Models\Address;
use Illuminate\Support\Facades\Log;
use Throwable;

class StoreAddressService
{
    public function execute(array $data)
    {
        try {
            return Address::query()
                ->create(
                    array_merge($data, ['zip_code' => preg_replace('/[^0-9]/', '', $data['zip_code'])])
                );
        } catch (Throwable $th) {
            Log::error($th);
        }
    }
}
