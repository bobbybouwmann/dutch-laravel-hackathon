<?php

declare(strict_types=1);

use App\Certificate;
use App\Laracast;
use App\Package;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 1000)->create(['email_verified_at' => null]);

        $users->each(function ($user) {
            factory(Laracast::class)->create(['user_id' => $user->id]);
            factory(Package::class)->create(['user_id' => $user->id]);
            factory(Certificate::class)->create(['user_id' => $user->id]);
        });
    }
}
