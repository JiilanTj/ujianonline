<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Portal - Exam Management System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-900 to-indigo-900 min-h-screen flex items-center justify-center p-4">
  <div class="max-w-md w-full bg-white bg-opacity-95 rounded-xl shadow-2xl p-8 relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-500 bg-opacity-10 rounded-full"></div>
    <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-indigo-500 bg-opacity-10 rounded-full"></div>
    
    <!-- Header -->
    <div class="text-center mb-8 relative z-10">
      <h1 class="text-2xl font-bold text-blue-800">Admin Ujian Online</h1>
      <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 mx-auto mt-3 rounded-full"></div>
    </div>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <form method="POST" action="{{ route('login') }}" class="relative z-10">
      @csrf
      
      <!-- Email Address -->
      <div class="mb-5">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }}</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i class="fas fa-envelope"></i>
          </span>
          <input id="email" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        </div>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>
      
      <!-- Password -->
      <div class="mb-5">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">
            <i class="fas fa-lock"></i>
          </span>
          <input id="password" class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" type="password" name="password" required autocomplete="current-password" />
          <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 cursor-pointer">
            <i id="toggleIcon" class="fas fa-eye"></i>
          </button>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
      </div>
      
      <!-- Remember Me -->
      <div class="flex items-center mb-5">
        <input id="remember_me" type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" name="remember">
        <label for="remember_me" class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</label>
      </div>
      
      <div class="flex items-center justify-between">
        @if (Route::has('password.request'))
          <a class="text-sm text-blue-600 hover:text-blue-800 transition-colors" href="{{ route('password.request') }}">
            {{ __('Forgot your password?') }}
          </a>
        @endif
        
        <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 uppercase text-sm tracking-wider">
          {{ __('Log in') }}
        </button>
      </div>
    </form>
    
    <!-- Footer decoration -->
    <div class="mt-8 pt-6 text-center text-xs text-gray-500 border-t border-gray-200">
      <p>Exam Management System © 2025</p>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleIcon = document.getElementById('toggleIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>