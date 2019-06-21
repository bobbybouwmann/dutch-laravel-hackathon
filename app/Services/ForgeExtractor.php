<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class ForgeExtractor
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://forge.laravel.com/api/v1/',
        ]);
    }

    public function getStatsForApiKey(string $apiToken)
    {
        $servers = $this->getServers($apiToken);

        return [
            'servers' => $servers->count(),
            'sites' => $servers->sum(function ($server) use ($apiToken) {
                $sites = $this->getSitesForServer($apiToken, $server);

                return $sites->count();
            }),
        ];
    }

    private function getServers(string $apiToken): Collection
    {
        $response = $this->client->get('servers', [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);

        return collect(json_decode((string) $response->getBody(), true)['servers']);
    }

    private function getSitesForServer(string $apiToken, array $server): Collection
    {
        $response = $this->client->get('servers/' . $server['id'] . '/sites', [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);

        return collect(json_decode((string) $response->getBody(), true)['sites']);
    }
}
