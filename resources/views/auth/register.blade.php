@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 col-xl-4">
        <div class="card auth-card">
            <div class="auth-header">
                <div class="auth-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3 class="mb-0">Create Account</h3>
                <p class="mb-0 opacity-75">Register for an admin account</p>
            </div>
            <div class="card-body p-4 p-md-5">
                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                        <span class="position-absolute top-50 end-0 translate-middle-y me-2 toggle-password" title="Show/Hide Password">
                            <i class="fas fa-eye"></i>
                        </span>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 position-relative">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        <span class="position-absolute top-50 end-0 translate-middle-y me-2 toggle-password-confirm" title="Show/Hide Password">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </button>
                    </div>

                    <div class="text-center">
                        <small>Already have an account? <a href="{{ route('login') }}">Login here</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password for main password
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.getElementById('password');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function(e) {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
        }
        
        // Toggle password for confirmation
        const togglePasswordConfirm = document.querySelector('.toggle-password-confirm');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        
        if (togglePasswordConfirm && passwordConfirmInput) {
            togglePasswordConfirm.addEventListener('click', function(e) {
                const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmInput.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
        }
    });
</script>
@endsection