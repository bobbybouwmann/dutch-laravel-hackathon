<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Packagist\Packagist;

class PackagistExtractor
{
    /**
     * @var Packagist
     */
    protected $packagist;

    public function __construct()
    {
        $this->packagist = new Packagist(new Client());
    }

    public function getStatsForVendor(string $vendor): array
    {
        try {
            $packagesList = collect($this->packagist->getPackagesByVendor($vendor)['packageNames']);
        } catch (Exception $e) {
            $packagesList = collect();
        }

        $laravelPackages = $this->parsePackageListToLaravelPackages($packagesList);

        return [
            'packages' => $laravelPackages,
            'stats' => $this->getTotalStats($laravelPackages),
        ];
    }


    protected function parsePackageListToLaravelPackages(Collection $packagesList): Collection
    {
        return $packagesList->map(function ($vendorPackage) {
            return $this->packagist->findPackageByName($vendorPackage)['package'];
        })->filter(function ($package) {
            $version = collect($package['versions'])->first();

            if (Str::contains('laravel', $version['keywords'])) {
                return true;
            }

            return false;
        });
    }

    protected function getTotalStats(Collection $packages): array
    {
        return [
            'number_of_packages' => $packages->count(),
            'github_stars' => $packages->sum('github_stars'),
            'favers' => $packages->sum('favers'),
            'package_dependents' => $packages->sum('dependents'),
            'downloads' => [
                'total' => $packages->sum(function ($package) {
                    return $package['downloads']['total'];
                }),
                'monthly' => $packages->sum(function ($package) {
                    return $package['downloads']['monthly'];
                }),
                'daily' => $packages->sum(function ($package) {
                    return $package['downloads']['daily'];
                }),
            ],
        ];
    }
}
