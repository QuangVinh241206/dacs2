<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayOSService
{
    public function createPaymentRequest(
        int $orderCode,
        int $amount,
        string $description,
        string $returnUrl,
        string $cancelUrl,
        ?string $buyerName = null,
    ): array {
        $baseUrl = rtrim((string) config('payos.base_url'), '/');
        $clientId = (string) config('payos.client_id');
        $apiKey = (string) config('payos.api_key');
        $checksumKey = (string) config('payos.checksum_key');

        if ($baseUrl === '' || $clientId === '' || $apiKey === '' || $checksumKey === '') {
            throw new \RuntimeException('PayOS config is missing. Please set PAYOS_CLIENT_ID, PAYOS_API_KEY, PAYOS_CHECKSUM_KEY.');
        }

        $dataToSign = sprintf(
            'amount=%d&cancelUrl=%s&description=%s&orderCode=%d&returnUrl=%s',
            $amount,
            $cancelUrl,
            $description,
            $orderCode,
            $returnUrl,
        );

        $signature = hash_hmac('sha256', $dataToSign, $checksumKey);

        $payload = [
            'orderCode' => $orderCode,
            'amount' => $amount,
            'description' => $description,
            'returnUrl' => $returnUrl,
            'cancelUrl' => $cancelUrl,
            'signature' => $signature,
        ];

        if ($buyerName) {
            $payload['buyerName'] = $buyerName;
        }

        $response = Http::withHeaders([
            'x-client-id' => $clientId,
            'x-api-key' => $apiKey,
            'Accept' => 'application/json',
        ])->post($baseUrl . '/v2/payment-requests', $payload);

        if (!$response->successful()) {
            Log::error('PayOS API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new \RuntimeException('PayOS API error: ' . $response->status());
        }

        $json = $response->json();

        // Expecting: { code, desc, data: { checkoutUrl, qrCode, ... } }
        $data = $json['data'] ?? [];

        return [
            'checkoutUrl' => $data['checkoutUrl'] ?? null,
            'qrCode' => $data['qrCode'] ?? null,
            'raw' => $json,
        ];
    }
}
