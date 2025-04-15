@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Parent Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Assigned Subjects -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">My Assigned Subjects</h2>
            <div class="space-y-4">
                @foreach($assignedSubjects as $assignment)
                    <div class="border-b pb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-lg">{{ $assignment->subject->name }}</h3>
                                <p class="text-gray-600 text-sm">Assigned by: {{ $assignment->assignedBy->name }}</p>
                            </div>
                            <a href="{{ route('parent.subjects.content', $assignment->subject->id) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                View Content
                            </a>
                        </div>
                    </div>
                @endforeach

                @if($assignedSubjects->isEmpty())
                    <p class="text-gray-600">No subjects assigned yet.</p>
                @endif
            </div>
        </div>

        <!-- Profile Section -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">My Profile</h2>
            <form action="{{ route('parent.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
                    <input type="text" name="name" id="name" 
                           value="{{ auth()->user()->name }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           required>
                </div>

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input type="text" name="username" id="username" 
                           value="{{ auth()->user()->username }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           required>
                </div>

                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Current Password</label>
                    <input type="password" name="current_password" id="current_password" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-4">
                    <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                    <input type="password" name="new_password" id="new_password" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-6">
                    <label for="new_password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update Profile
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
