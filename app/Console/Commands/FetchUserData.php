<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\SyncCertification;
use App\Jobs\SyncLaracast;
use App\Jobs\SyncPackagist;
use App\User;
use Illuminate\Console\Command;

class FetchUserData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laraboard:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue a job for each user to sync all points from the different systems';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::verified()->get();

        $users->each(function (User $user) {
            dispatch(new SyncCertification($user));
            dispatch(new SyncLaracast($user));
            dispatch(new SyncPackagist($user));
        });
    }
}
