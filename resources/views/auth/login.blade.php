@extends('layouts.app')

@section('content')

     <!-- Form Section -->
  
      <section class="flex-grow flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-4 py-8 sm:py-12 mt-10 mb-10">
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
                  <h2 class="text-2xl font-semibold text-white">Good to see you again!</h2>
                  <p class="text-white/80 mt-2">Login in to access your documents and tools.</p>
                </div>
              </div>
              
              <!-- Right side - Login Form -->
              <div class="w-full sm:w-1/2 p-8 sm:p-12">
                <div class="max-w-md mx-auto">
                  <!-- Form header -->
                  <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Login</h2>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Access your PDFThisThat account</p>
                  </div>
                  
                  <!-- Form -->
                  <form method="POST" action="{{ route('login') }}" class="space-y-6 ">
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
                          @error('email')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                          @enderror
                      </div>
                    </div>
                    
                    <!-- Password -->
                    <div>
                      <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                      <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                          <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                          </svg>
                        </div>
                        <input id="password" name="password" type="password" required
                          class="block w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition @error('password') is-invalid @enderror"
                          placeholder="Enter your password" autocomplete="current-password">
                          @error('password')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                          @enderror
                      </div>
                    </div>
                    
                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                      <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="h-4 w-4 text-primary-500 focus:ring-primary-400 border-gray-300 dark:border-gray-600 rounded" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Remember me</span>
                      </label>
                      @if (Route::has('password.request'))
                      <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary-500 hover:text-primary-600 dark:hover:text-primary-400">Forgot password?</a>
                      @endif
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit"
                      class="w-full py-3 px-4 bg-primary-500 hover:bg-primary-600 text-white font-semibold rounded-lg shadow-md transition duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                      Login
                    </button>
                  </form>
                  
                  <!-- Divider -->
                  <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                      <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                      <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">Or continue with</span>
                    </div>
                  </div>
                  
                  <!-- Social Login -->
                  <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('Google_Auth') }}"
                      class="w-full flex items-center justify-center gap-2 py-2.5 px-4 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                      <svg class="w-5 h-5 text-[#EA4335]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.545 10.239v3.821h5.445c-0.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866 0.549 3.921 1.453l2.814-2.814c-1.784-1.667-4.143-2.685-6.735-2.685-5.522 0-10 4.477-10 10s4.478 10 10 10c8.396 0 10-7.524 10-10 0-0.67-0.069-1.325-0.189-1.955h-9.811z"/>
                      </svg>
                      <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Sign in with Google</span>
                    </a>
                  </div>
                  
                  <!-- Register link -->
                    @if (Route::has('register'))
                  <p class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-semibold text-primary-500 hover:text-primary-600 dark:hover:text-primary-400">Register</a>
                  </p>
                  @endif
                </div>
              </div>
            </div>
      </section>


@endsection
