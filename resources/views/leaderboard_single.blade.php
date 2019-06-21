<a href="{{ route('profile.show', $user) }}">
<div class="hover:bg-blue-800 hover:text-white cursor-pointer max-w-md w-full rounded bg-white overflow-hidden shadow-lg mb-6 mr-4">
    <div class="px-6 py-4 flex">
        <div class="mr-4">@include('larapoints')</div>
        <div class="ml-2">
            <span class="text-3xl font-bold">{{ $loop->iteration }}. </span>
            <span class="text-3xl font-normal">{{ $user->name }}</span>
            <p class="mt-6 text-center">
                @if ($user->laracast instanceof \App\Laracast)
                    <span class="hover:bg-blue-400 mb-4 inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-semibold text-blue-900 mr-2">
                        Laracasts
                    </span>
                @endif
                @if ($user->package instanceof \App\Package)
                    <a class="hover:bg-blue-400 mb-4 inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-semibold text-blue-900 mr-2">
                        Packages
                    </a>
                @endif
                @if ($user->certificate instanceof \App\Certificate)
                    <a class="hover:bg-blue-400 mb-4 inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-semibold text-blue-900">
                        Certification
                    </a>
                @endif
                @if ($user->forge instanceof \App\Forge)
                    <a class="hover:bg-blue-400 mb-4 inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-semibold text-blue-900">
                        Forge
                    </a>
                @endif
            </p>
        </div>
    </div>
</div>
</a>