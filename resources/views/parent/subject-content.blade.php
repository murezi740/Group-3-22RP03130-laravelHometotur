@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">{{ $subject->name }} Content</h1>
        <a href="{{ route('parent.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Dashboard
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        @if($contents->isEmpty())
            <div class="p-6 text-center text-gray-600">
                No content available for this subject yet.
            </div>
        @else
            <div class="divide-y">
                @foreach($contents as $content)
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-2">{{ $content->title }}</h2>
                        <p class="text-gray-600 text-sm mb-4">
                            Posted by: {{ $content->tutor->name }} | 
                            {{ $content->created_at->format('M d, Y') }}
                        </p>
                        <div class="prose max-w-none">
                            {{ $content->body }}
                        </div>
                        @if($content->files->count() > 0)
                            <div class="mt-4 border-t pt-4">
                                <h3 class="font-semibold text-gray-700 mb-2">Attachments</h3>
                                <div class="space-y-2">
                                    @foreach($content->files as $file)
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            <a href="{{ asset($file->filename) }}" target="_blank" 
                                               class="text-blue-600 hover:text-blue-800 hover:underline">
                                                {{ $file->original_filename }}
                                                <span class="text-gray-500 text-sm">({{ number_format($file->size / 1024, 2) }} KB)</span>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
