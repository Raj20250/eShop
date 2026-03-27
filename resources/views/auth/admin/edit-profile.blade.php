@extends('layouts.admin.admin-main')

@section('title', 'Edit My Profile')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-6">
    
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Edit Profile Information</h1>
        <p class="text-gray-500 mt-1">Manage your personal details and keep your account secure.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="p-8">
                <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Full Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" required 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                            @error('name')
    <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p>
@enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Email Address</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" required 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                       @error('email')
    <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p>
@enderror
                        </div>
                    </div>

                    

                    <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all transform hover:-translate-y-1">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
            <div class="p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="bg-red-50 p-2 rounded-lg mr-3">🛡️</span> Security & Password
                </h3>

                <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    @error('current_password')
    <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
@enderror

@error('new_password')
    <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
@enderror

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">Current Password</label>
                            <input type="password" name="current_password" required 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wide">New Password</label>
                            <input type="password" name="new_password" required 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-red-500 outline-none transition">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold hover:bg-gray-900 shadow-lg transition-colors">
                        Update My Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection