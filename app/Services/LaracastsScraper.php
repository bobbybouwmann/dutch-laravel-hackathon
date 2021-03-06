<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;

class LaracastsScraper
{
    private $html;
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getDataFor(string $username)
    {
        try {
            $this->html = $this->getProfile($username);
        } catch (\Exception $e) {
            return new NullLaracastsScraper();
        }

        if ($this->match($this->statsRegex()) === []) {
            return new NullLaracastsScraper();
        }

        return $this;
    }

    public function statistics()
    {
        $matches = $this->match($this->statsRegex());

        return [
            'experience' => (int) str_replace(',', '', $matches[0]),
            'lessons' => (int) str_replace(',', '', $matches[1]),
            'best_replies' => (int) str_replace(',', '', $matches[2]),
            'badges' => $this->badges(),
        ];
    }

    protected function badges()
    {
        $levels = collect([
            'beginner' => 'is-beginner',
            'intermediate' => 'is-intermediate',
            'advanced' => 'is-advanced',
        ]);

        $awardedBadges = $this->match($this->awardedBadgesRegex());

        $badges = $levels->map(function ($level) use ($awardedBadges) {
            return count(array_keys($awardedBadges, $level, true));
        })->all();

        $badges['total'] = count($awardedBadges);

        $badges['available_badges'] = count($this->match($this->totalBadgesRegex()));

        return $badges;
    }

    private function statsRegex()
    {
        return '/<strong class="tw-text-white tw-text-2xl tw-block">\r*\n*\s*(\d*,?\d*,?\d*)\r*\n*\s*<\/strong>/is';
    }

    private function awardedBadgesRegex()
    {
        return '/li class="achievement\s+(.*)\s+has-been-awarded.*"/';
    }

    private function totalBadgesRegex()
    {
        return '/li class="achievement\s+(.*)\s+.*"/';
    }

    private function match($regex)
    {
        preg_match_all($regex, $this->html, $matches);

        return $matches[1];
    }

    private function getProfile(string $username)
    {
        return (string) $this->client
            ->request('GET', "https://laracasts.com/@{$username}")
            ->getBody();
    }
}
