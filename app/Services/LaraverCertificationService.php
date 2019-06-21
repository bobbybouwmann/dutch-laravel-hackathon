<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

class LaravelCertificateValidationService
{
    public const CERT_URL = 'https://exam.laravelcert.com/is/%s/certified-since/%s';

    public const VALID_CERT_TEXT = 'is a Certified Laravel Developer';

    public $certInfo;

    public $client;

    public $url;

    public function __construct($name, $date)
    {
        $name = mb_strtolower($name);
        $name = str_replace(' ', '-', $name);

        $this->client = new Client;
        $this->url = sprintf(static::CERT_URL, $name, $date);
        $this->certInfo = $this->getCertificationInfo();
    }

    public function isValid()
    {
        if (mb_strpos($this->certInfo, static::VALID_CERT_TEXT)) {
            return true;
        }

        return false;
    }

    private function getCertificationInfo()
    {
        $response = $this->client->get($this->url);

        if ($response->getStatusCode() === 200) {
            return $response->getBody()->getContents();
        }
    }
}
