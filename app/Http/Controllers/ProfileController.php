<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Certificate;
use App\Http\Requests\ProfileRequest;
use App\Laracast;
use App\Package;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        /** @var User $user */
        $user = auth()->user();
        $user->load(['certificate', 'laracast', 'package']);

        return view('profile.edit', compact('user'));
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->update($request->only(['name', 'email']));

        if ($request->filled('date')) {
            if ($user->certificate instanceof Certificate) {
                $user->certificate->update(['date_of_certification', $request->get('date')]);
            } else {
                $user->certificate()->create(['date_of_certification', $request->get('date')]);
            }
        }

        if ($request->filled('laracast')) {
            if ($user->laracast instanceof Laracast) {
                $user->laracast->update(['username', $request->get('laracast')]);
            } else {
                $user->laracast()->create(['username', $request->get('laracast')]);
            }
        }

        if ($request->filled('vendor')) {
            if ($user->package instanceof Package) {
                $user->package->update(['vendor', $request->get('vendor')]);
            } else {
                $user->package()->create(['vendor', $request->get('vendor')]);
            }
        }

        return redirect()->route('profile.edit')->with(['success' => 'true']);
    }
}
