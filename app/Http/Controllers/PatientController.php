<?php

namespace App\Http\Controllers;

use App\Jobs\ImportPatientJob;
use App\Models\Patient;
use App\Services\Patient\DeletePatientService;
use App\Services\Patient\ListPatientService;
use App\Services\Patient\ShowPatientService;
use App\Services\Patient\StorePatientService;
use App\Services\Patient\UpdatePatientService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ListPatientService $service)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'birth' => 'nullable|date|before_or_equal:now',
            'cpf' => 'nullable|string|max:11',
            'cns' => 'nullable|string|max:15'
        ]);

        $patients = $service->execute($validated);

        return response()->json($patients, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, StorePatientService $service)
    {
        $validated = $request->validate([
            'photo' => 'nullable|file|mimes:png|max:20480',
            'name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'birth' => 'required|date|before_or_equal:now',
            'cpf' => 'required|cpf',
            'cns' => 'required|cns'
        ]);

        $patient = $service->execute($validated);

        return response()->json($patient, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient, Request $request, ShowPatientService $service)
    {
        $patient = $service->execute($patient);

        return response()->json($patient, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient, UpdatePatientService $service)
    {
        $validated = $request->validate([
            'photo' => 'file|mimes:png|max:20480',
            'name' => 'string|max:255',
            'mother_name' => 'string|max:255',
            'birth' => 'date|before_or_equal:now',
            'cns' => 'cns'
        ]);

        $service->execute($patient, $validated);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient, DeletePatientService $service)
    {
        $service->execute($patient);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $path = $file->storeAs('imports', Carbon::now()->timestamp . '.csv');

        dispatch(new ImportPatientJob($path))->onQueue('import');

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
