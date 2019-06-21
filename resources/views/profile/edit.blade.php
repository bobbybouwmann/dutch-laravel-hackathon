@extends('layouts.app')

@section('content')
    <div class="container mx-auto">

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-8 rounded relative"
                 role="alert">
                <strong class="font-bold">Awesome!</strong>
                <span class="block sm:inline">Your data will now be retrieved shortly and we'll update the leaderboard!</span>
            </div>
        @endif

        <div class="flex flex-wrap justify-center">

            <div class="w-full max-w-sm">

                <div class="flex flex-col break-words bg-white border border-2 rounded shadow-md">

                    <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
                        {{ __('Profile information') }}
                    </div>

                    <form class="w-full p-6" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="flex flex-wrap mb-6">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Name') }} *
                            </label>

                            <input id="name" type="text"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline{{ $errors->has('name') ? ' border-red-500' : '' }}"
                                   name="name" value="{{ old('name', $user->name) }}" required autofocus>

                            @if ($errors->has('name'))
                                <p class="text-red-500 text-xs italic mt-4">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>

                        <div class="flex flex-wrap mb-6">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Email') }} *
                            </label>

                            <input id="email" type="email"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline{{ $errors->has('email') ? ' border-red-500' : '' }}"
                                   name="email" value="{{ old('email', $user->email) }}" required>

                            @if ($errors->has('email'))
                                <p class="text-red-500 text-xs italic mt-4">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        <div class="flex flex-wrap mb-6">
                            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Date of Laravel Certification') }}
                            </label>

                            <input id="date" type="date"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline{{ $errors->has('date') ? ' border-red-500' : '' }}"
                                   name="date"
                                   value="{{ old('date', $user->certificate ? $user->certificate->date_of_certification->format('Y-m-d') : null) }}">

                            @if ($errors->has('name'))
                                <p class="text-red-500 text-xs italic mt-4">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>

                        <div class="flex flex-wrap mb-6">
                            <label for="laracast" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Laracasts username') }}
                            </label>

                            <input id="laracast" type="text"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline{{ $errors->has('laracast') ? ' border-red-500' : '' }}"
                                   name="laracast"
                                   value="{{ old('laracast', $user->laracast ? $user->laracast->username : null) }}">

                            @if ($errors->has('laracast'))
                                <p class="text-red-500 text-xs italic mt-4">
                                    {{ $errors->first('laracast') }}
                                </p>
                            @endif
                        </div>

                        <div class="flex flex-wrap mb-6">
                            <label for="vendor" class="block text-gray-700 text-sm font-bold mb-2">
                                {{ __('Packagist vendor') }}
                            </label>

                            <input id="vendor" type="text"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline{{ $errors->has('vendor') ? ' border-red-500' : '' }}"
                                   name="vendor"
                                   value="{{ old('vendor', $user->package ? $user->package->vendor : null) }}">

                            @if ($errors->has('vendor'))
                                <p class="text-red-500 text-xs italic mt-4">
                                    {{ $errors->first('vendor') }}
                                </p>
                            @endif
                        </div>

                        <div class="flex flex-wrap items-center">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                {{ __('Save profile') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
