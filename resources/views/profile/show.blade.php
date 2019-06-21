@extends ('layouts.app')

@section ('content')
    <div class="container mx-auto w-full">
        <div class="mx-auto p-2">

            <h1 class="mb-6 text-5xl text-center leading-loose font-base">
                Profile of <span class="font-bold">{{ $user->name }}</span>
            </h1>

            @if ($user->laracast instanceof \App\Laracast)
                <div class="flex flex-wrap justify-center w-full">
                    <div class="max-w-md w-full rounded bg-white overflow-hidden shadow-lg mb-6 mr-4">
                        <div class="px-6 py-4 flex">
                            <div class="ml-2">
                                <div class="font-bold text-3xl mb-4">Laracasts</div>
                                <p class="text-gray-700 text-base mb-2">
                                    Lessons completed: <span class="font-bold">{{ $user->laracast->lessons }}</span>
                                </p>
                                <p class="text-gray-700 text-base mb-2">
                                    Experience: <span class="font-bold">{{ $user->laracast->experience }}</span>
                                </p>
                                <p class="text-gray-700 text-base mb-2">
                                    Best replies: <span class="font-bold">{{ $user->laracast->best_replies }}</span>
                                </p>
                                <p class="text-gray-700 text-base mb-2">
                                    Badges: <pspan class="font-bold">{{ $user->laracast->badge_beginner + $user->laracast->badge_intermidiate + $user->laracast->badge_advanced }} / 21</pspan>
                                </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($user->certificate instanceof \App\Certificate)
                <div class="flex flex-wrap justify-center w-full">
                    <div class="max-w-md w-full rounded bg-white overflow-hidden shadow-lg mb-6 mr-4">
                        <div class="px-6 py-4 flex">
                            <div class="ml-2">
                                <div class="font-bold text-3xl mb-4">Certification</div>
                                <p class="text-gray-700 text-base mb-2">
                                    Completed on
                                    <span class="font-bold">{{ $user->certificate->date_of_certification->format('Y-m-d') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($user->forge instanceof \App\Forge)
                <div class="flex flex-wrap justify-center w-full">
                    <div class="max-w-md w-full rounded bg-white overflow-hidden shadow-lg mb-6 mr-4">
                        <div class="px-6 py-4 flex">
                            <div class="ml-2">
                                <div class="font-bold text-3xl mb-4">Forge</div>
                                <p class="text-gray-700 text-base mb-2">
                                    Servers: <span class="font-bold">{{ $user->forge->servers }}</span>
                                </p>
                                <p class="text-gray-700 text-base mb-2">
                                    Sites: <span class="font-bold">{{ $user->forge->sites }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($user->package instanceof \App\Package)
                <div class="flex flex-wrap justify-center w-full">
                    <div class="max-w-md w-full rounded bg-white overflow-hidden shadow-lg mb-6 mr-4">
                        <div class="px-6 py-4 flex">
                            <div class="ml-2">
                                <div class="font-bold text-3xl mb-4">Packagist</div>
                                <p class="text-gray-700 text-base mb-2">
                                    Vendor name: <span class="font-bold">{{ $user->package->vendor }}</span>
                                </p>
                                <p class="text-gray-700 text-base mb-2">
                                    Number of packages: <span class="font-bold">{{ $user->package->number_of_packages }}</span>
                                </p>
                                <p class="text-gray-700 text-base mb-2">
                                    Github stars: <span class="font-bold">{{ $user->package->github_stars }}</span>
                                </p>
                                <p class="text-gray-700 text-base mb-2">
                                    Favers: <span class="font-bold">{{ $user->package->favers }}</span>
                                </p>
                                <p class="text-gray-700 text-base mb-2">
                                    Package dependents: <span class="font-bold">{{ $user->package->package_dependents }}</span>
                                </p>
                                <p class="text-gray-700 text-base mb-2">
                                    All time downloads: <span class="font-bold">{{ $user->package->downloads_total }}</span>
                                </p>
                                <p class="text-gray-700 text-base mb-2">
                                    Monthly downloads: <span class="font-bold">{{ $user->package->downloads_monthly }}</span>
                                </p>
                                <p class="text-gray-700 text-base mb-2">
                                    Daily downloads: <span class="font-bold">{{ $user->package->downloads_daily }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
