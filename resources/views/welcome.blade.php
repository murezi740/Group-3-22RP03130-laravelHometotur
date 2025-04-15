<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Tutor</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-[Poppins] bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">Home Tutor</h1>
                    </div>
                </div>
                <div class="flex items-center">
                    @if (Route::has('login'))
                        <div class="px-6 py-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-700 hover:text-indigo-600">Logout</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-indigo-600">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
            <div class="mb-12 lg:mb-0">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
                    Transform Your Learning Journey
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Connect with expert tutors, access quality education, and achieve your academic goals.
                </p>
                <div class="space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-200">Go to Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-200">Get Started</a>
                        <a href="{{ route('login') }}" class="border border-indigo-600 text-indigo-600 px-6 py-3 rounded-lg hover:bg-indigo-50 transition duration-200">Sign In</a>
                    @endauth
                </div>
            </div>
            <div class="relative">
                <img src="https://source.unsplash.com/random/800x600/?education,study" alt="Education" class="rounded-lg shadow-xl">
            </div>
        </div>

        <!-- Features Section -->
        <div class="mt-24">
            <h3 class="text-3xl font-bold text-center mb-12">Why Choose Home Tutor?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                    <div class="text-indigo-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Expert Tutors</h4>
                    <p class="text-gray-600">Access a network of qualified and experienced tutors across various subjects.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                    <div class="text-indigo-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Quality Resources</h4>
                    <p class="text-gray-600">Access comprehensive study materials, assignments, and resources.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                    <div class="text-indigo-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold mb-2">Flexible Learning</h4>
                    <p class="text-gray-600">Learn at your own pace with personalized schedules and online sessions.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
