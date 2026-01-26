@extends('layouts.app')
@section('content')
<div class="flex min-h-screen items-center justify-center bg-zinc-100 px-4">
    <div class="w-full max-w-sm rounded-2xl border border-zinc-200 bg-white p-8 shadow-sm">
        <h1 class="text-2xl font-bold text-zinc-900">Sign in</h1>
        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-zinc-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 @error('email') border-red-500 @enderror" />
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-zinc-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 @error('password') border-red-500 @enderror" />
                @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center">
                <input id="remember" type="checkbox" name="remember" class="h-4 w-4 rounded border-zinc-300 text-indigo-600" />
                <label for="remember" class="ml-2 text-sm text-zinc-700">Remember me</label>
            </div>
            <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-indigo-700">Sign in</button>
        </form>
        <p class="mt-4 text-center text-sm text-zinc-600"><a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Register</a></p>
    </div>
</div>
@endsection
