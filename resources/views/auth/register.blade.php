@extends('layouts.app')
@section('content')
<div class="flex min-h-screen items-center justify-center bg-zinc-100 px-4">
    <div class="w-full max-w-sm rounded-2xl border border-zinc-200 bg-white p-8 shadow-sm">
        <h1 class="text-2xl font-bold text-zinc-900">Register</h1>
        <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-zinc-700">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 @error('name') border-red-500 @enderror" />
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-zinc-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 @error('email') border-red-500 @enderror" />
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-zinc-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 @error('password') border-red-500 @enderror" />
                @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-zinc-700">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2" />
            </div>
            <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-indigo-700">Register</button>
        </form>
        <p class="mt-4 text-center text-sm text-zinc-600"><a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Sign in</a></p>
    </div>
</div>
@endsection
