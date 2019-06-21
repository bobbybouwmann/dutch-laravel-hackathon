<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Package;
use App\Services\PackagistExtractor;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncPackagist implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param PackagistExtractor $packagistExtractor
     * @return void
     */
    public function handle(PackagistExtractor $packagistExtractor): void
    {
        $package = $this->user->package;

        if (!$package instanceof Package) {
            return;
        }

        $data = $packagistExtractor->getStatsForVendor($package->vendor);
        $statistics = $data['stats'];
        
        $this->user->package->update([
            'number_of_packages' => $statistics['number_of_packages'],
            'github_stars' => $statistics['github_stars'],
            'favers' => $statistics['favers'],
            'package_dependents' => $statistics['package_dependents'],
            'downloads_total' => $statistics['downloads']['total'],
            'downloads_monthly' => $statistics['downloads']['monthly'],
            'downloads_daily' => $statistics['downloads']['daily'],
        ]);
    }
}
