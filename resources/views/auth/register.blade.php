@extends('layouts.layout')
@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-center text-gray-700">新規登録</h2>

            <form method="POST" action="{{ route('register') }}" class="mt-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" class="text-gray-600 font-semibold"/>
                    <x-text-input id="name" class="block w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-indigo-300"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" class="text-gray-600 font-semibold"/>
                    <x-text-input id="email" class="block w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-indigo-300"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-600 font-semibold"/>
                    <x-text-input id="password" class="block w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-indigo-300"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-600 font-semibold"/>
                    <x-text-input id="password_confirmation" class="block w-full px-4 py-2 mt-2 border rounded-lg focus:ring focus:ring-indigo-300"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
                </div>

                <!-- Register Button & Login Link -->
                <div class="flex items-center justify-between mt-6">
                    <a class="text-sm text-indigo-500 hover:underline" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="px-6 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
