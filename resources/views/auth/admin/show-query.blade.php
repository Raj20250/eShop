@extends('layouts.admin.admin-main')

@section('title', 'Client Queries - Admin')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Customer Support Queries</h1>

    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Customer Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Contact No.</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Location</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($queries as $item)
                <tr class="hover:bg-indigo-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $item->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $item->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $item->city }}, {{ $item->country }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <a href="{{ route('admin.queries.edit', $item->id) }}" 
                           class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 shadow-md transition duration-150">
                            View & Reply
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection