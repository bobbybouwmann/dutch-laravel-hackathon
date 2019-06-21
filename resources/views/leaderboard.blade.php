@extends ('layouts.app')

@section ('content')
    <div class="container mx-auto w-full">
        <div class="mx-auto p-2">

            <div class="mb-4 text-center text-xl">
                <div class="mb-2">Welcome, <strong>{{ auth()->user()->name }}</strong></div>
                <div class="tracking-tight">
                    <a href="/profile/edit" class="text-blue-800 hover:underline hover:text-blue-400">
                        Show profile
                    </a>
                </div>
            </div>

            <h1 class="mb-6 text-5xl text-center leading-loose font-base">Leader board</h1>

            <div class="flex flex-wrap justify-center w-full">
                @forelse ($users as $user)
                    @include('leaderboard_single', ['user' => $user])
                @empty
                    'No users'
                @endforelse
            </div>

        </div>
    </div>
@endsection