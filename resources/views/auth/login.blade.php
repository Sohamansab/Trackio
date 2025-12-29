<x-guest-layout>
    <div class="auth-container">
        <!-- Left Side - Branding -->
        <div class="auth-left">
            <h2>Welcome to<br>Trackio</h2>
            <p>The complete employee attendance management system. Track time, manage leaves, and boost productivity.</p>

            <div class="features">
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>Real-time Attendance Tracking</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>Easy Leave Management</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>Detailed Reports & Analytics</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check"></i>
                    <span>Multi-shift Support</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="auth-right">
            <div class="auth-logo">Trackio</div>
            <h1 class="auth-title">Sign In</h1>
            <p class="auth-subtitle">Welcome back! Please enter your details.</p>

            @if(session('status'))
                <div style="background: #d1fae5; border: 1px solid #a7f3d0; color: #065f46; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px;">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control"
                               placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-icon-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" class="form-control"
                               placeholder="Enter your password" required>
                    </div>
                </div>

                <div class="form-footer">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-primary-custom">
                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                </button>
            </form>

        </div>
    </div>
</x-guest-layout>