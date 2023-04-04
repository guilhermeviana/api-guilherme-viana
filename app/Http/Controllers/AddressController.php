<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Patient;
use App\Services\Address\GetCepService;
use App\Services\Address\StoreAddressService;
use App\Services\Address\UpdateAddressService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Patient $patient, StoreAddressService $service)
    {
        $validated = $request->validate([
            'zip_code' => 'required|max:9|formato_cep',
            'street' => 'required|string|max:255',
            'number' => 'required|max:10|string',
            'complement' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|max:2|uf',
        ]);

        $address = $service->execute(array_merge(['patient_id' => $patient->id], $validated));

        return response()->json($address, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient, Address $address, UpdateAddressService $service)
    {
        $validated = $request->validate([
            'zip_code' => 'required|max:9|formato_cep',
            'street' => 'required|string|max:255',
            'number' => 'required|max:10|string',
            'complement' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|max:2|uf',
        ]);

        $service->execute($address, $validated);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function getCep(Request $request, string $cep, GetCepService $service)
    {
        return $service->execute($cep);
    }
}
