<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Laracast;
use App\Services\LaracastsScraper;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncLaracast implements ShouldQueue
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
     * @param LaracastsScraper $laracastsScraper
     * @return void
     */
    public function handle(LaracastsScraper $laracastsScraper): void
    {
        $laracast = $this->user->laracast;

        if (!$laracast instanceof Laracast) {
            return;
        }

        $statistics = $laracastsScraper->getDataFor($laracast->username)->statistics();

        $this->user->laracast->update([
            'experience' => $statistics['experience'],
            'lessons' => $statistics['lessons'],
            'best_replies' => $statistics['best_replies'],
            'badge_beginner' => $statistics['badges']['beginner'],
            'badge_intermediate' => $statistics['badges']['intermediate'],
            'badge_advanced' => $statistics['badges']['advanced'],
        ]);
    }
}
