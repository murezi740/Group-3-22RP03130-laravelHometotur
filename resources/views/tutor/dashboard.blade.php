@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Tutor Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Create Content -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Create Content</h2>
            <form action="{{ route('tutor.contents.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="subject_id" class="block text-gray-700 text-sm font-bold mb-2">Select Subject</label>
                    <select name="subject_id" id="subject_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select a subject</option>
                        @foreach($subjects as $assignment)
                            <option value="{{ $assignment->subject->id }}">{{ $assignment->subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                    <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="body" class="block text-gray-700 text-sm font-bold mb-2">Content</label>
                    <textarea name="body" id="body" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="files" class="block text-gray-700 text-sm font-bold mb-2">Attach Files (Optional)</label>
                    <input type="file" name="files[]" id="files" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
                    <p class="text-gray-600 text-xs mt-1">You can upload multiple files (max 10MB each)</p>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create Content
                </button>
            </form>
        </div>

        <!-- Assign Subject to Parent -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Assign Subject to Parent</h2>
            <form action="{{ route('tutor.assignments.create') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="parent_id" class="block text-gray-700 text-sm font-bold mb-2">Select Parent</label>
                    <select name="parent_id" id="parent_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select a parent</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="subject_id" class="block text-gray-700 text-sm font-bold mb-2">Select Subject</label>
                    <select name="subject_id" id="subject_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select a subject</option>
                        @foreach($subjects as $assignment)
                            <option value="{{ $assignment->subject->id }}">{{ $assignment->subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Assign Subject
                </button>
            </form>
        </div>

        <!-- My Contents -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">My Contents</h2>
            <div class="space-y-4">
                @foreach($contents as $content)
                    <div class="border-b pb-4">
                        <h3 class="font-bold text-lg">{{ $content->title }}</h3>
                        <p class="text-gray-600 text-sm">Subject: {{ $content->subject->name }}</p>
                        <p class="mt-2">{{ Str::limit($content->body, 150) }}</p>
                        @if($content->files->count() > 0)
                            <div class="mt-2">
                                <p class="text-sm font-semibold">Attachments:</p>
                                <ul class="list-disc list-inside text-sm text-blue-600">
                                    @foreach($content->files as $file)
                                        <li>
                                            <a href="{{ asset($file->filename) }}" target="_blank" class="hover:underline">
                                                {{ $file->original_filename }} ({{ number_format($file->size / 1024, 2) }} KB)
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- My Subjects -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">My Subjects</h2>
            <div class="space-y-2">
                @foreach($subjects as $assignment)
                    <div class="p-3 bg-gray-50 rounded">
                        <span class="font-semibold">{{ $assignment->subject->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
