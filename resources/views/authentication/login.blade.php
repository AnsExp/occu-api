@extends('layouts.app')

@section('title', __('auth.login'))

@section('content')
    <div class="flex items-center justify-center bg-gray-50">
        <div class="w-full max-w-sm">

            <div class="mb-8 text-center">
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900">
                    {{ config('app.name') }}
                </h1>
                <p class="mt-1 text-sm text-gray-500">{{ __('auth.login') }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-8 py-8">

                @if ($errors->any())
                    <div class="mb-5 rounded-lg bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-600">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="post" action="{{ route('auth.login') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            {{ __('auth.email') }}
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            autocomplete="email" placeholder="mail@example.com"
                            class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                {{ __('auth.password') }}
                            </label>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                    </div>

                    <div class="flex items-center gap-2">
                        <input id="remember" type="checkbox" name="remember"
                            class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900 cursor-pointer">
                        <label for="remember" class="text-sm text-gray-600 cursor-pointer select-none">
                            {{ __('auth.remember') }}
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-700 active:bg-gray-800 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                        {{ __('auth.login') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection