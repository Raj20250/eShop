@extends('layouts.admin.admin-main')

@section('title', 'User Management - E-Shop')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">User Management</h1>

    <div class="mb-6 bg-white p-4 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-center gap-4">
        
        <form action="{{ url('admin/users') }}" method="GET" class="w-full md:w-1/2 flex items-center space-x-2">
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       placeholder="Search by Name or Email...">
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm font-medium transition duration-150">
                Search
            </button>
        </form>

        <div class="text-sm font-medium text-gray-600 flex items-center gap-4">
            Total Users: <span class="text-indigo-600 font-bold">{{ $users->total() }}</span>
            <a href="{{ route('admin.users.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 font-bold">
               Add New User
            </a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Registered Users</h2>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    @forelse($users as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.users.show', $item->id) }}" class="text-blue-600 hover:underline mr-2">View</a>
                            <a href="{{ route('admin.users.edit', $item->id) }}" class="text-indigo-600 hover:underline mr-2">Edit</a>
                            <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 font-bold">
                            No users found for "{{ request('search') }}"
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</div>

@endsection