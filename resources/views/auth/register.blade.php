@extends('layouts.app')

@section('content')

    <!-- Form Section -->

        <section class="flex-grow flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-4 py-8 sm:py-12 mt-10">
            <!-- Smaller Container -->
            <div class="relative w-full max-w-4xl bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-xl flex flex-col sm:flex-row">
                
                <!-- Decorative Border (unchanged) -->
                <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-primary-600 opacity-5 dark:opacity-10 -z-10 hidden sm:block"></div>
                
                <!-- Left Side -->
                <div class="w-full sm:w-1/2 bg-gradient-to-br from-primary-500 to-primary-600 p-6 sm:p-8 flex flex-col justify-center items-center text-center">
                    <!-- Logo/Brand -->
                    <div class="mb-8 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h4 class="text-3xl font-bold text-white mt-4">PDFThisThat</h1>
                    </div>

                    
                    <!-- Welcome text (hidden on mobile) -->
                    <div class="hidden sm:block mt-8">
                    <h2 class="text-2xl font-semibold text-white">Welcome to our platform!</h2>
                    <p class="text-white/80 mt-2">Register and start exploring the tools.</p>
                    </div>
                </div>
                
                <!-- Right Side -->
                <div class="w-full sm:w-1/2 px-4 py-6 sm:px-6 sm:py-8">
                <div class="max-w-sm mx-auto">
                    
                    <!-- Header -->
                    <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Register</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Create your PDFThisThat account</p>
                    </div>
                    
                    <!-- Form -->
                    <form method="POST" action="{{ route('register') }}" class="space-y-4 text-sm">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name" placeholder="Enter your name" required
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-primary-500 focus:ring-1 focus:outline-none transition" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" name="email" placeholder="Enter your email" required
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-primary-500 focus:ring-1 focus:outline-none transition" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Password</label>
                        <input type="password" name="password" placeholder="Enter your password" required
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-primary-500 focus:ring-1 focus:outline-none transition" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-300">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="Confirm password" required
                        class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-primary-500 focus:ring-1 focus:outline-none transition" />
                    </div>

                    <!-- Remember -->
                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center text-gray-700 dark:text-gray-300 text-xs">
                        <input type="checkbox" name="remember"
                            class="h-4 w-4 text-primary-500 border-gray-300 dark:border-gray-600 rounded" />
                        <span class="ml-2">Remember me</span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-2 px-4 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-md shadow transition duration-150">
                        Register
                    </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-xs text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-2">
                        Or continue with
                    </div>
                    </div>

                    <!-- Google Button -->
                    <a href="#" class="w-full flex items-center justify-center gap-2 py-2 px-4 border border-gray-300 dark:border-gray-700 rounded-md text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <svg class="w-4 h-4 text-[#EA4335]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.545 10.239v3.821h5.445c-0.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866 0.549 3.921 1.453l2.814-2.814c-1.784-1.667-4.143-2.685-6.735-2.685-5.522 0-10 4.477-10 10s4.478 10 10 10c8.396 0 10-7.524 10-10 0-0.67-0.069-1.325-0.189-1.955h-9.811z"/>
                    </svg>
                    <span>Sign in with Google</span>
                    </a>
                </div>
                <!-- Register link -->
                        @if (Route::has('login'))
                        <p class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
                        Do you have an account? 
                        <a href="{{ route('login') }}" class="font-semibold text-primary-500 hover:text-primary-600 dark:hover:text-primary-400">Login</a>
                        </p>
                        @endif
                </div>
            </div>
        </section>


@endsection