<?php

declare(strict_types=1);

namespace App\Services;

use Spatie\Browsershot\Browsershot;

class LaravelCertificateValidationService
{
    public const CERT_URL = 'https://exam.laravelcert.com/is/%s/certified-since/%s';

    public const VALID_CERT_TEXT = 'is a Certified Laravel Developer';

    public $certInfo;

    public function __construct($name, $date)
    {
        $name = mb_strtolower($name);
        $name = str_replace(' ', '-', $name);

        $this->certInfo = $this->getCertificationInfo($name, $date);
    }

    public function isValid()
    {
        if (mb_strpos($this->certInfo, static::VALID_CERT_TEXT)) {
            return true;
        }

        return false;
    }

    private function getCertificationInfo($name, $date)
    {
        $url = sprintf(static::CERT_URL, $name, $date);
        
        return Browsershot::url($url)->bodyHtml();
    }
}
