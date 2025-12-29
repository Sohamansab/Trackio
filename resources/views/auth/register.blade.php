<x-guest-layout>
    <div class="auth-container">
        <!-- Left Side - Branding -->
        <div class="auth-left">
            <h2>Join<br>Trackio</h2>
            <p>Start managing your team's attendance efficiently. Get real-time insights and streamline your HR processes.</p>

            <div class="features">
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>Quick & Easy Setup</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>Secure & Reliable</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>24/7 Access Anywhere</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>Free Support</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="auth-right">
            <div class="auth-logo">Trackio</div>
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Get started with your free account today.</p>

            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" id="name" name="name" class="form-control"
                               placeholder="Enter your full name" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control"
                               placeholder="Enter your email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control"
                               placeholder="Create a password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                               placeholder="Confirm your password" required>
                    </div>
                </div>

                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-user-plus me-2"></i> Create Account
                </button>
            </form>

            <div class="auth-switch">
                Already have an account? <a href="{{ route('login') }}">Sign In</a>
            </div>
        </div>
    </div>
</x-guest-layout>
