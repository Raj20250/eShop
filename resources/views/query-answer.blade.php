@extends('layouts.client.client-main')

@section('title', 'Query Details - E-Shop')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <a href="{{ route('client.show-query') }}" class="inline-flex items-center text-indigo-600 font-bold mb-6 hover:underline">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to List
    </a>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="p-8 border-b border-gray-100">
            <div class="flex justify-between items-start mb-4">
                <h2 class="text-3xl font-extrabold text-gray-900">Query Details</h2>
                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ $query->created_at->format('d M, Y') }}</span>
            </div>
            <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-indigo-500">
                <p class="text-sm font-bold text-indigo-600 uppercase mb-2">Your Question:</p>
                <p class="text-gray-700 leading-relaxed italic">"{{ $query->description }}"</p>
            </div>
        </div>

        <div class="p-8 bg-indigo-50">
            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"></path></svg>
                Admin's Response
            </h3>
            
            @if($query->reply)
                <div class="prose max-w-none text-gray-800 leading-relaxed">
                    {{ $query->reply }}
                </div>
            @else
                <div class="flex items-center text-gray-500 bg-white p-4 rounded-lg border border-indigo-100 shadow-sm">
                    <svg class="w-5 h-5 mr-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Our team is reviewing your query. We will reply shortly.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection