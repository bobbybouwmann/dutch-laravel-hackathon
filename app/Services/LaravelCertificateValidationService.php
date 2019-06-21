<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;

class LaravelCertificateValidationService
{
    public const CERT_URL = 'https://exam.laravelcert.com/is/%s/certified-since/%s';

    public const VALID_CERT_TEXT = 'is a Certified Laravel Developer';

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function validateFor(string $name, Carbon $date): bool
    {
        $name = str_replace(' ', '-', mb_strtolower($name));
        $url = sprintf(static::CERT_URL, $name, $date->format('Y-m-d'));

        $info = $this->getCertificationForUrl($url);

        if (mb_strpos($info, static::VALID_CERT_TEXT)) {
            return true;
        }

        return false;
    }

    private function getCertificationForUrl(string $url): string
    {
        $response = $this->client->get($url);

        if ($response->getStatusCode() === 200) {
            return $response->getBody()->getContents();
        }

        return '';
    }
}
