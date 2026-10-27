<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" sizes="16x16">
  
  <!-- CSS Files -->
  <link rel="stylesheet" href="{{ asset('css/remixicon.css') }}">
  <link rel="stylesheet" href="{{ asset('css/lib/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  
  <!-- SweetAlert2 CSS (For nice error messages) -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
  <div class="d-lg-flex bg-white">
    <div class="w-50 d-lg-flex d-none overflow-hidden">
      <img src="{{ asset('images/thumbs/login-img.png') }}" alt="Login Image" class="w-100 h-100 object-fit-cover">
    </div>
    <div class="lg-w-50 px-24 py-32 d-flex justify-content-center align-items-center">
      <div class="max-w-540-px mx-auto">
        <a href="{{ route('login') }}" class="">
          <img src="{{ isset($settings) && $settings->logo ? asset('storage/' . $settings->logo) : asset('images/logo.png') }}" 
         alt="site logo" class="light-logo">
        </a>
        <div class="mt-32 mb-32">
          <h1 class="h6 fw-bold text-primary-light mb-8">Welcome Back 👋</h1>
          <p class="text-sm text-secondary-light mb-0">Log in to your account to continue</p>
        </div>

        <!-- ✅ Form Action and Method Updated -->
        <form action="{{ route('login.store') }}" method="POST" class="d-flex flex-column gap-32 submit-form">
          @csrf

          <div class="d-flex flex-column gap-16">
            <!-- Email Field -->
            <div>
              <label for="email" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                Email Address <span class="text-danger-600">*</span>
              </label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" 
                     class="email-field form-control @error('email') is-invalid @enderror" 
                     placeholder="Enter your email" required autofocus>
              @error('email')
                <small class="text-danger-600 mt-4 d-block">{{ $message }}</small>
              @enderror
            </div>

            <!-- Password Field -->
            <div>
              <label for="password" class="text-sm fw-semibold text-primary-light d-inline-block mb-8">
                Password <span class="text-danger-600">*</span>
              </label>
              <div class="position-relative">
                <input type="password" id="password" name="password" 
                       class="password-field form-control @error('password') is-invalid @enderror" 
                       placeholder="Enter your password" required>
                <button type="button"
                  class="toggle-password btn p-0 border-0 bg-transparent position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light cursor-pointer ri-eye-line"
                  data-toggle="#password" aria-label="Toggle password visibility">
                </button>
              </div>
              @error('password')
                <small class="text-danger-600 mt-4 d-block">{{ $message }}</small>
              @enderror
            </div>
          </div>

          <div class="d-flex justify-content-between gap-2">
            <div class="form-check style-check d-flex align-items-center">
              <!-- ✅ Fixed typo: remeber -> remember -->
              <input class="form-check-input border border-neutral-400" type="checkbox" name="remember" id="remember" value="1">
              <label class="form-check-label" for="remember">Remember me</label>
            </div>
            {{-- <a href="javascript:void(0)" class="text-primary-600 fw-medium text-decoration-underline">Forgot Password?</a> --}}
          </div>

          <div>
            <button type="submit" class="loginBtn btn btn-primary-600 text-sm btn-sm px-12 py-16 w-100 radius-8">Log In</button>
          </div>

         
        </form>

      
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/lib/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('js/lib/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- ✅ SweetAlert for Inactive Account or General Auth Errors -->
  @if ($errors->has('email') && str_contains($errors->first('email'), 'inactive'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          icon: 'warning',
          title: 'Account Inactive',
          text: @json($errors->first('email')),
          confirmButtonColor: '#dc3545'
        });
      });
    </script>
  @endif
</body>
</html>