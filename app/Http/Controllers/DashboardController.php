<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::with(['laracast', 'forge', 'package', 'certificate'])->orderBy('larapoints', 'desc')->take(10)->get();

        return view('leaderboard', compact('users'));
    }
}
