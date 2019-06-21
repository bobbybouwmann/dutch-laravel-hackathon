<?php

namespace App\Console\Commands;

use App\Services\LaraPointsCalculator;
use App\User;
use Illuminate\Console\Command;

class CalculateScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laraboard:calculate-score';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate the score of all users.';

    /**
     * @var LaraPointsCalculator
     */
    private $laraPointsCalculator;

    /**
     * Create a new command instance.
     *
     * @param LaraPointsCalculator $laraPointsCalculator
     */
    public function __construct(LaraPointsCalculator $laraPointsCalculator)
    {
        parent::__construct();

        $this->laraPointsCalculator = $laraPointsCalculator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();

        $users->each(function (User $user) {
            $user->update([
                'larapoints' => $this->laraPointsCalculator->calculateForUser($user),
            ]);
        });
    }
}
