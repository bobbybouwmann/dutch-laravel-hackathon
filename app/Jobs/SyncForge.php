<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Forge;
use App\Services\ForgeExtractor;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncForge implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

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
     * @param ForgeExtractor $forgeExtractor
     * @return void
     */
    public function handle(ForgeExtractor $forgeExtractor): void
    {
        $forge = $this->user->forge;

        if (!$forge instanceof Forge) {
            return;
        }

        $statistics = $forgeExtractor->getStatsForApiKey($forge->api_token);

        $this->user->forge->update($statistics);
    }
}
