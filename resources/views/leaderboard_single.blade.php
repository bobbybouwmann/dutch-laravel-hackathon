<div class="max-w-md w-full rounded bg-white overflow-hidden shadow-lg mb-6 mr-4">
    <div class="px-6 py-4 flex">
        <div class="mr-4">@include('larapoints')</div>
        <div class="ml-2">
            <span class="text-3xl font-bold">{{ $loop->iteration }}. </span>
            <span class="text-3xl font-normal">{{ $user->name }}</span>
            <p class="mt-6 text-center">
                <a href="#" class="hover:bg-blue-400 mb-4 inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-semibold text-blue-900 mr-2">
                    Laracasts
                </a>
                <a href="#" class="hover:bg-blue-400 mb-4 inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-semibold text-blue-900 mr-2">
                    Packages
                </a>
                <a href="#" class="hover:bg-blue-400 mb-4 inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-semibold text-blue-900">
                    Certification
                </a>
            </p>
        </div>
    </div>
</div>


{{--<div class="max-w-sm rounded bg-white overflow-hidden shadow-lg mb-6 mr-8">--}}
{{--    <div class="px-6 py-4">--}}
{{--        <div class="font-thin text-3xl mb-2">--}}
{{--            <span class="text-3xl font-bold">{{ $loop->iteration }}.</span>--}}
{{--            {{ $user->name }}--}}
{{--        </div>--}}
{{--        <p class="text-gray-700 text-base px-2">--}}
{{--            @include('larapoints')--}}
{{--        </p>--}}
{{--    </div>--}}
{{--    <div class="px-6 py-4">--}}
{{--        <span class="inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-semibold text-blue-900 mr-2">--}}
{{--            Laracasts--}}
{{--        </span>--}}
{{--        <span class="inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-semibold text-blue-900 mr-2">--}}
{{--            Packages--}}
{{--        </span>--}}
{{--        <span class="inline-block bg-blue-100 rounded-full px-3 py-1 text-sm font-semibold text-blue-900">--}}
{{--            Certification--}}
{{--        </span>--}}
{{--    </div>--}}
{{--</div>--}}