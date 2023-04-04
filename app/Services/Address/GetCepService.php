<?php

namespace App\Services\Address;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class GetCepService
{
    public function execute(string $cep)
    {
        try {
            if (Cache::get($cep)) {
                return Cache::get($cep);
            }

            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true);

                if (isset($data['erro'])) {
                    return response()->json(['message' => 'CEP não encontrado'], 404);
                } else {
                    return Cache::remember($cep, 86400, function () use ($response) {
                        return $response->json();
                    });
                }
            } else {
                return response()->json(['message' => 'Erro ao consultar o CEP'], 500);
            }
        } catch (Throwable $th) {
            Log::error($th);
        }
    }
}
