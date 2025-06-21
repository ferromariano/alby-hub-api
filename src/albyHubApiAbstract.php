<?php

namespace AlbyHubApi;

abstract class albyHubApiAbstract
{
    private string $baseUrl;
    private ?string $jwtToken;

    public function __construct(string $baseUrl, ?string $jwtToken = null)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->jwtToken = $jwtToken;
    }

    public function request(string $method, string $endpoint, array $data = []): mixed
    {
        $url = $this->baseUrl . $endpoint;
        $ch = curl_init($url);

        $headers = ['Accept: application/json'];
        if ($this->jwtToken) {
            $headers[] = 'Authorization: Bearer ' . $this->jwtToken;
        }

        if (in_array($method, ['POST', 'PATCH', 'PUT', 'DELETE'])) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $headers[] = 'Content-Type: application/json';
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);

        curl_close($ch);

        if ($error) {
            throw new \Exception("Request error: $error");
        }

        $decoded = json_decode($response, true);
        if ($httpCode >= 400) {
            throw new \Exception("HTTP $httpCode: " . ($decoded['message'] ?? $response));
        }

        return $decoded;
    }

}