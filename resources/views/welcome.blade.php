<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome to Our App</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @livewire('welcome-header')

            <main class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 space-y-8">
                {{-- Hero Section --}}
                <section class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 text-white p-20 rounded-lg shadow-lg text-center min-h-screen flex items-center justify-center">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class="text-5xl font-extrabold mb-6">Welcome to Our Awesome App!</h1>
                        <p class="text-2xl mb-8">Discover how our application can simplify your life and boost your productivity.</p>
                        <a href="/register" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-md shadow-sm text-indigo-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                            Get Started Now
                        </a>
                    </div>
                </section>

                {{-- How it Works Section --}}
                <section id="how-it-works" class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">How It Works</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-indigo-100 rounded-full">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Step 1: Sign Up</h3>
                            <p class="text-gray-700 dark:text-gray-300">Quick and easy registration to get you started in minutes.</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-indigo-100 rounded-full">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Step 2: Explore Features</h3>
                            <p class="text-gray-700 dark:text-gray-300">Dive into our powerful tools and discover what you can achieve.</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-indigo-100 rounded-full">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Step 3: Achieve Goals</h3>
                            <p class="text-gray-700 dark:text-gray-300">Utilize our app to reach your objectives efficiently and effectively.</p>
                        </div>
                    </div>
                </section>

                {{-- Features Section --}}
                <section id="features" class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">Key Features</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Feature One</h3>
                            <p class="text-gray-700 dark:text-gray-300">A brief description of feature one, highlighting its benefits and how it helps users.</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Feature Two</h3>
                            <p class="text-gray-700 dark:text-gray-300">Another compelling feature that adds value and improves the user experience significantly.</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Feature Three</h3>
                            <p class="text-gray-700 dark:text-gray-300">The third key feature, explaining its core functionality and why users will love it.</p>
                        </div>
                    </div>
                </section>

                {{-- Testimonials Section --}}
                <section id="testimonials" class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">What Our Users Say</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                            <p class="text-gray-700 dark:text-gray-300 italic">"This app has transformed the way I work. Highly recommend it to everyone!"</p>
                            <p class="text-right mt-4 font-semibold text-gray-800 dark:text-gray-200">- Jane Doe, CEO of Example Corp</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
                            <p class="text-gray-700 dark:text-gray-300 italic">"An incredibly intuitive and powerful tool. It's a game-changer for our team."</p>
                            <p class="text-right mt-4 font-semibold text-gray-800 dark:text-gray-200">- John Smith, Project Manager</p>
                        </div>
                    </div>
                </section>
            </main>
        </div>
        @livewireScripts
    </body>
</html>