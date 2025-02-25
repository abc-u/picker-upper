@extends('layouts.layout')
@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <h2 class="text-2xl font-semibold text-center text-gray-700">ログイン</h2>

            <form method="POST" action="{{ route('login') }}" class="mt-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-600 font-semibold"/>
                    <x-text-input id="email" class="block w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-indigo-300"
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-600 font-semibold"/>
                    <x-text-input id="password" class="block w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-indigo-300"
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mt-4">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" name="remember">
                    <label for="remember_me" class="ml-2 text-gray-600 text-sm"> {{ __('Remember me') }}</label>
                </div>

                <!-- Login Button & Forgot Password -->
                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-500 hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="px-6 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
