<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\PatientController;
use App\Models\Address;
use App\Models\Patient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'patients'], function () {
        Route::post('', [PatientController::class, 'store']);
        Route::post('/import', [PatientController::class, 'import']);
        Route::get('', [PatientController::class, 'index']);
        Route::get('{patient}', [PatientController::class, 'show'])->missing(function () {
            throw new ModelNotFoundException('Not found');
        });
        Route::put('{patient}', [PatientController::class, 'update'])->missing(function () {
            throw new ResourceNotFoundException('Not found');
        });

        Route::delete('{patient}', [PatientController::class, 'destroy'])->missing(function () {
            throw new ResourceNotFoundException('Not found');
        });

        Route::group(['prefix' => '{patient}/addresses'], function () {
            Route::post('', [AddressController::class, 'store']);
            Route::put('{address}', [AddressController::class, 'update'])->missing(function () {
                throw new ResourceNotFoundException('Not found');
            });
        });
    });

    Route::get('cep/{cep}', [AddressController::class, 'getCep'])->where('cep', '[0-9]+');
});
