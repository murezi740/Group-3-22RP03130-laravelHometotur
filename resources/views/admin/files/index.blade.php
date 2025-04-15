@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6">File Management</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">File</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Content</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tutor</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Size</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($files as $file)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ asset($file->filename) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">
                                    {{ $file->original_filename }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $file->content->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $file->content->subject->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $file->content->tutor->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ number_format($file->size / 1024, 2) }} KB
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <form action="{{ route('admin.files.scan', $file) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-600 hover:text-yellow-800">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.files.delete', $file) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $files->links() }}
        </div>
    </div>
</div>
@endsection
