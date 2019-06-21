<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Certificate;
use App\Forge;
use App\Http\Requests\ProfileRequest;
use App\Jobs\SyncCertification;
use App\Jobs\SyncForge;
use App\Jobs\SyncLaracast;
use App\Jobs\SyncPackagist;
use App\Laracast;
use App\Package;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return $this->show(auth()->user());
    }

    public function show(User $user): View
    {
        $view = view('profile.show');

        $view->user = $user;
        $view->laracast = $user->laracast;
        $view->certificate = $user->certificate;
        //$view->forge = $user->forge;

        return $view;
    }

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
                $user->certificate->update(['date_of_certification' => $request->get('date')]);
            } else {
                $user->certificate()->create(['date_of_certification' => $request->get('date')]);
            }
        }

        if ($request->filled('laracast')) {
            if ($user->laracast instanceof Laracast) {
                $user->laracast->update(['username' => $request->get('laracast')]);
            } else {
                $user->laracast()->create(['username' => $request->get('laracast')]);
            }
        }

        if ($request->filled('vendor')) {
            if ($user->package instanceof Package) {
                $user->package->update(['vendor' => $request->get('vendor')]);
            } else {
                $user->package()->create(['vendor' => $request->get('vendor')]);
            }
        }

        if ($request->filled('forge')) {
            if ($user->forge instanceof Forge) {
                $user->forge->update(['api_token' => $request->get('forge')]);
            } else {
                $user->forge()->create(['api_token' => $request->get('forge')]);
            }
        }

        // Make sure the stats of the user are updated using the queue
        dispatch(new SyncCertification($user));
        dispatch(new SyncLaracast($user));
        dispatch(new SyncPackagist($user));
        dispatch(new SyncForge($user));

        return redirect()->route('profile.edit')->with(['success' => 'true']);
    }
}
