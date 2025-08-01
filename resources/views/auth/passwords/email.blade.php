@extends('layouts.app')

@section('content')

 <!-- Form Section -->

    <section class="flex-grow flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-4 sm:py-12 mt-12">
          <!-- Container with subtle gradient border effect -->
          <div class="relative w-full max-w-4xl bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-2xl flex flex-col sm:flex-row">
            <!-- Decorative gradient border (hidden on mobile) -->
            <div class="absolute inset-0 bg-gradient-to-r from-primary-500 to-primary-600 opacity-5 dark:opacity-10 -z-10 hidden sm:block"></div>
            
            <!-- Left side - Branding/Image -->
            <div class="w-full sm:w-1/2 bg-gradient-to-br from-primary-500 to-primary-600 p-8 sm:p-12 flex flex-col justify-center items-center text-center">
              <!-- Logo/Brand -->
              <div class="mb-8 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h4 class="text-3xl font-bold text-white mt-4">PDFThisThat</h1>
              </div>

              
              <!-- Welcome text (hidden on mobile) -->
              <div class="hidden sm:block mt-8">
                <h2 class="text-2xl font-semibold text-white">Reset Password!</h2>
                <p class="text-white/80 mt-2">Reset password to access your PDFThisThat account</p>
              </div>
            </div>
            
            <!-- Right side - Login Form -->
            <div class="w-full sm:w-1/2 p-8 sm:p-12">
              <div class="max-w-md mx-auto">
                <!-- Form header -->
                <div class="text-center mb-10">
                  <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Forgot Password</h2>
                  <p class="mt-2 text-gray-600 dark:text-gray-400 text-md">Enter your Registered email to reset your password.</p>
                </div>
                @if (session('status'))
                        <div class="alert alert-success text-red-600 text-sm" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                
                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6 ">
                  @csrf
                  
                  <!-- Email -->
                  <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                    <div class="relative">
                      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                          <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                      </div>
                      <input id="email" name="email" type="email" required autofocus
                        class="block w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('email') is-invalid @enderror"
                        placeholder="Enter your email" value="{{ old('email') }}" autocomplete="email">
                        
                    </div>
                    @error('email')
                                    <span class="alert alert-success text-red-600 text-sm" role="alert"> 
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                  </div>

                  <!-- Submit Button -->
                  <button type="submit"
                    class="w-full py-3 px-4 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg shadow-md transition duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                    Submit
                  </button>
                </form>
              </div>
            </div>
          </div>
    </section>


@endsection
