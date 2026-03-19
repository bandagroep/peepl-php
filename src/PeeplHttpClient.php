<?php

declare(strict_types=1);

namespace Peepl;

class PeeplHttpClient
{
    private string $apiToken;
    private string $baseUrl;

    public function __construct(string $apiToken, string $baseUrl = 'https://api.peepl.io/v1/admin')
    {
        $this->apiToken = $apiToken;
        $this->baseUrl  = rtrim($baseUrl, '/');
    }

    /**
     * Execute an HTTP request.
     *
     * @throws PeeplException
     */
    public function request(string $method, string $path, array $body = []): mixed
    {
        $url = $this->baseUrl . '/' . ltrim($path, '/');

        // The Peepl API requires a trailing slash on every endpoint.
        $parsedPath = parse_url($url, PHP_URL_PATH) ?? '';
        if (!str_ends_with($parsedPath, '/')) {
            // Preserve any query string
            $queryString = parse_url($url, PHP_URL_QUERY);
            $baseUrl     = strtok($url, '?');
            $url         = rtrim($baseUrl, '/') . '/';
            if ($queryString) {
                $url .= '?' . $queryString;
            }
        }

        $headers = [
            'Content-Type: application/json',
            'Authorization: Token ' . $this->apiToken,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,     $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  strtoupper($method));

        if (!empty($body) && in_array(strtoupper($method), ['POST', 'PUT', 'PATCH'], true)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }

        $result     = curl_exec($ch);
        $httpStatus = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError  = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            throw new PeeplException('cURL error: ' . $curlError);
        }

        $decoded = json_decode((string) $result, true);

        if ($httpStatus === 429) {
            throw new PeeplException(
                'Rate limit exceeded (429 Too Many Requests). Please wait and retry.',
                429,
                $decoded
            );
        }

        if ($httpStatus >= 400) {
            $msg = $decoded['detail'] ?? ('HTTP error ' . $httpStatus);
            throw new PeeplException($msg, $httpStatus, $decoded);
        }

        return $decoded;
    }

    public function get(string $path, array $query = []): mixed
    {
        if (!empty($query)) {
            $path .= '?' . http_build_query($query);
        }

        return $this->request('GET', $path);
    }

    public function post(string $path, array $body = []): mixed
    {
        return $this->request('POST', $path, $body);
    }

    public function put(string $path, array $body = []): mixed
    {
        return $this->request('PUT', $path, $body);
    }

    public function delete(string $path): mixed
    {
        return $this->request('DELETE', $path);
    }
}
