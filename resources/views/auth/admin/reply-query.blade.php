@extends('layouts.admin.admin-main')

@section('title', 'Reply to Query - Admin')

@section('content')
<div class="p-6 max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Review Query</h2>
        <a href="{{ route('admin.queries.index') }}" class="text-indigo-600 font-bold hover:underline">← Back to List</a>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
        <div class="p-6 bg-gray-50 border-b border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase">Customer Email</p>
                <p class="text-lg font-semibold text-gray-800">{{ $query->email }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase">Phone Number</p>
                <p class="text-lg font-semibold text-gray-800">{{ $query->phone }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase">Location</p>
                <p class="text-gray-800">{{ $query->address }}, {{ $query->city }}, {{ $query->country }}</p>
            </div>
        </div>
        
        <div class="p-6">
            <p class="text-xs font-bold text-gray-500 uppercase mb-2">Customer Message</p>
            <div class="p-4 bg-indigo-50 rounded-lg text-gray-800 leading-relaxed border border-indigo-100">
                {{ $query->description }}
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Write Your Response</h3>
        <form action="{{ route('admin.queries.update', $query->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <textarea name="reply" rows="6" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm"
                          placeholder="Type your reply here..." required>{{ $query->reply }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 text-white font-bold px-8 py-3 rounded-xl hover:bg-green-700 shadow-lg transform active:scale-95 transition duration-150">
                    Submit & Send Reply
                </button>
            </div>
        </form>
    </div>
</div>
@endsection