<?php

namespace App\Services\Address;

use App\Models\Address;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateAddressService
{
    public function execute(Address $address, array $data)
    {
        try {
            return $address
                ->update(
                    array_merge($data, ['zip_code' => preg_replace('/[^0-9]/', '', $data['zip_code'])])
                );
        } catch (Throwable $th) {
            Log::error($th);
        }
    }
}
