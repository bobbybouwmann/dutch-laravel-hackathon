<?php

declare(strict_types=1);

namespace App\Services;

use App\Certificate;
use App\Laracast;
use App\Package;
use App\User;

class LaraPointsCalculator
{
    public function calculateForUser(User $user)
    {
        $laracastScore = $this->calculateScoreForPlatform($user->laracast);

        $packagistScore = $this->calculateScoreForPlatform($user->package);

        $certificationScore = $this->calculateScoreForPlatform($user->certificate);

        return ($laracastScore + $packagistScore + $certificationScore);
    }

    /**
     * Lookup table for distribution of LaraPoints
     *
     * @return array
     */
    private function scoreLookup()
    {
        return [
            'Laracast' => [
                'experience'            =>  1/2000,
                'lessons'               =>  1/20,
                'best_replies'          =>  1,
                'badge_beginner'        =>  1,
                'badge_intermediate'    => 1,
                'badge_advanced'        => 1,
            ],

            'Package' => [
                'number_of_packages'    => 3,
                'downloads_total'       => 1/1000,
                'github_stars'          => 1/10,
                'package_dependents'    => 1/10,
                'favers'                => 1/10,
            ],

            'Certificate'             => [
                'valid'     => 100,
            ],
        ];
    }

    /**
     * Calculate the points per platform.
     * The basename of the underlying class is reflected in the
     * keys of the scoreTable array
     *
     * @param $platform Laracast|Package|Certificate
     * @return float
     */
    private function calculateScoreForPlatform($platform)
    {
        $points = collect($this->scoreLookup()[class_basename($platform)])
            ->map(function ($points, $scoreableProperty) use ($platform) {
                return $platform->{$scoreableProperty} * $points;
            });

        return ceil($points->sum());
    }
}
