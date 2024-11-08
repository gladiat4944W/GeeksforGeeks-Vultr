<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InferenceController extends Controller
{
    private $vultrApiKey;
    private $vultrEndpoint;

    public function __construct()
    {
        $this->vultrApiKey = env('VULTR_API_KEY');
        $this->vultrEndpoint = env('VULTR_INFERENCE_ENDPOINT');
    }

    public function chat(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->vultrApiKey,
            'Content-Type' => 'application/json',
        ])->post($this->vultrEndpoint, [
            'prompt' => $request->input('message'),
            'max_tokens' => 500,
            'temperature' => 0.7
        ]);

        return response()->json([
            'response' => $response->json()
        ]);
    }
}
