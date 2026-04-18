@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
<div class="text-center mb-8">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary text-tertiary mb-4 shadow-lg">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
    </div>
    <h1 class="text-2xl font-bold text-primary mb-1">Kantin Maria</h1>
    <p class="text-gray-500 text-sm">Masuk untuk mengelola sistem kantin</p>
</div>

<div class="bg-white border border-gray-200 rounded-xl p-8 shadow-sm">
    @if(session('error'))
    <div class="bg-red-50 text-red-600 p-3 rounded-md text-sm mb-5 border border-red-200">
        {{ session('error') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email Akses</label>
            <input type="email" name="email" required autofocus
                   class="w-full bg-white border border-gray-300 text-gray-900 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors"
                   placeholder="nama@kantinmaria.com" value="{{ old('email') }}">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Kata Sandi</label>
            <input type="password" name="password" required
                   class="w-full bg-white border border-gray-300 text-gray-900 rounded-md px-4 py-2.5 text-sm focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors"
                   placeholder="••••••••">
        </div>
        <button type="submit" class="w-full py-2.5 bg-primary hover:bg-secondary text-white rounded-md text-sm font-semibold transition-colors duration-300 shadow-md">
            Masuk ke Sistem
        </button>
    </form>
</div>
<div class="text-center mt-6 text-xs text-gray-400">
    &copy; {{ date('Y') }} Kantin Maria. Enterprise Management.
</div>
@endsection
