<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    public static function saveImageFromUrl(string $url): ?string
    {
        try {
            // Gera um nome único para a imagem
            $filename = 'img_' . Str::random(10) . '.' . pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);

            // Faz o download
            $imageData = Http::get($url)->body();

            // Salva no disco (public/temp)
            $path = 'public/temp/' . $filename;
            Storage::put($path, $imageData);

            // Retorna caminho absoluto para usar no PDF
            return public_path('storage/temp/' . $filename);
        } catch (\Exception $e) {
            Log::error("Erro ao baixar imagem: " . $e->getMessage());
            return null;
        }
    }
}
