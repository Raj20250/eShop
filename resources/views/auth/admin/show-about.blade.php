@extends('layouts.admin.admin-main')

@section('title', 'Manage About Us - E-Shop')

@section('content')

<div class="container mx-auto p-6 max-w-5xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manage About Us Page</h1>
        <p class="text-gray-600">Update the information displayed on the client-side About Us page.</p>
    </div>

    <div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-700">Content Configuration</h2>
        </div>

        <form action="{{ route('admin.queries.update') }}" method="POST" class="p-8">
            @csrf @method('PUT') <div class="grid grid-cols-1 gap-8">
                
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Main Title</label>
                    <input type="text" name="title" id="title" 
                           value="{{ $about->title ?? '' }}" 
                           placeholder="Enter page heading..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition duration-200">
                </div>

                <div>
                    <label for="content" class="block text-sm font-bold text-gray-700 mb-2">Main Description / Content</label>
                    <textarea name="content" id="content" rows="8" 
                              placeholder="Write your company story here..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition duration-200">{{ $about->content ?? '' }}</textarea>
                </div>

                <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                    <label for="mission" class="block text-sm font-bold text-blue-900 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Our Mission Statement
                    </label>
                    <textarea name="mission" id="mission" rows="3" 
                              placeholder="Describe your company's mission..."
                              class="w-full px-4 py-3 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 outline-none transition duration-200 shadow-sm">{{ $about->mission ?? '' }}</textarea>
                </div>

                <div class="bg-green-50 p-6 rounded-xl border border-green-100">
                    <label for="vision" class="block text-sm font-bold text-green-900 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Our Vision Statement
                    </label>
                    <textarea name="vision" id="vision" rows="3" 
                              placeholder="Describe your company's future vision..."
                              class="w-full px-4 py-3 border border-green-200 rounded-lg focus:ring-2 focus:ring-green-400 outline-none transition duration-200 shadow-sm">{{ $about->vision ?? '' }}</textarea>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-bold shadow-lg transform active:scale-95 transition duration-150 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Update About Information
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection