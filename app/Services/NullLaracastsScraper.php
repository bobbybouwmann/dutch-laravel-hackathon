<?php

namespace App\Services;


class NullLaracastsScraper
{
    public function statistics()
    {
        return [
            'experience'    => $matches[0] ?? 0,
            'lessons'       => $matches[1] ?? 0,
            'best_replies'  => $matches[2] ?? 0,
            'badges'        => $this->badges(),
        ];
    }
    
    public function badges()
    {
        return [
            'beginner'          => 0,
            'intermediate'      => 0,
            'advanced'          => 0,
            'total'             => 0,
            'available_badges'  => 21,
        ];
    }
}