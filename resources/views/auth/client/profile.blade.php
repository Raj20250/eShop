@extends('layouts.client.client-main')

@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-6">
    
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Account Overview</h1>
            <p class="text-gray-500 mt-1">Your current profile and account settings.</p>
        </div>
        <a href="{{ route('profile.edit') }}" 
           class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all transform hover:-translate-y-1">
            Edit My Profile
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="p-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <span class="bg-indigo-50 p-2 rounded-lg mr-3">👤</span> Personal Details
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-wide">Full Name</p>
                    <p class="text-lg font-semibold text-gray-800 mt-1">{{ Auth::user()->name }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl">
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-wide">Email Address</p>
                    <p class="text-lg font-semibold text-gray-800 mt-1">{{ Auth::user()->email }}</p>
                </div>

                
            </div>

            <div class="mt-10 pt-8 border-t border-gray-100 flex justify-between items-center">
                <p class="text-gray-400 text-sm italic">Member since {{ Auth::user()->created_at->format('M Y') }}</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-600 font-bold hover:text-red-800 flex items-center transition">
                        <span class="mr-2">🚪</span> Logout from Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection