@extends('layouts.admin.admin-main')

@section('title', 'View User - E-Shop')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">View User</h1>
    <div class="bg-white p-4 rounded shadow">
        <p><strong>ID:</strong> {{ $user->id }}</p>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ $user->role }}</p>
    </div>

    <a href="{{ route('admin.users.index') }}" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
        Back to Users
    </a>
</div>
@endsection