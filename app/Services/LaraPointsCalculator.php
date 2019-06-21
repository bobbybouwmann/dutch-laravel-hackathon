<?php

declare(strict_types=1);

namespace App\Services;

use App\Laracast;
use App\User;
use Illuminate\Database\Eloquent\Model;

class LaraPointsCalculator
{
    public function calculateForUser(User $user): float
    {
        $laracastScore = $this->calculateScoreForPlatform($user->laracast);

        $packagistScore = $this->calculateScoreForPlatform($user->package);

        $certificationScore = $this->calculateScoreForPlatform($user->certificate);

        $forgeScore = $this->calculateScoreForPlatform($user->forge);

        return round($laracastScore + $packagistScore + $certificationScore + $forgeScore);
    }

    /**
     * Lookup table for distribution of LaraPoints
     *
     * @return array
     */
    private function scoreLookup(): array
    {
        return [
            'Laracast' => [
                'experience' => 1 / 2000,
                'lessons' => 1 / 20,
                'best_replies' => 1,
                'badge_beginner' => 1,
                'badge_intermediate' => 1,
                'badge_advanced' => 1,
            ],

            'Package' => [
                'number_of_packages' => 3,
                'downloads_total' => 1 / 1000,
                'github_stars' => 1 / 10,
                'package_dependents' => 1 / 10,
                'favers' => 1 / 10,
            ],

            'Certificate' => [
                'valid' => 100,
            ],

            'Forge' => [
                'servers' => 10,
                'sites' => 10,
            ],
        ];
    }

    /**
     * Calculate the points per platform.
     * The basename of the underlying class is reflected in the
     * keys of the scoreTable array
     *
     * @param Laracast $platform |Package|Certificate
     * @return float
     */
    private function calculateScoreForPlatform($platform): float
    {
        if (!$platform instanceof Model) {
            return 0;
        }

        $points = collect($this->scoreLookup()[class_basename($platform)])
            ->map(function ($points, $scoreableProperty) use ($platform) {
                return $platform->{$scoreableProperty} * $points;
            });

        return ceil($points->sum());
    }
}
