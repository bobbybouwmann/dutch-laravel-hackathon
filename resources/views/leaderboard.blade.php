@extends ('layouts.app')

@section ('content')
    <div class="container mx-auto w-full">
        <div class="mx-auto p-2">
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