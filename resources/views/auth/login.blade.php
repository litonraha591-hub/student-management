<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', system-ui, sans-serif; min-height: 100vh; background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%); display: flex; align-items: center; justify-content: center; }
        .login-card { background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; max-width: 900px; width: 100%; display: flex; min-height: 500px; }
        .login-left { flex: 1; background: linear-gradient(135deg, #4f46e5, #7c3aed); display: flex; flex-direction: column; align-items: center; justify-content: center; color: #fff; padding: 40px; text-align: center; }
        .login-left i { font-size: 4rem; margin-bottom: 20px; }
        .login-left h2 { font-size: 1.5rem; margin-bottom: 10px; }
        .login-left p { opacity: 0.8; }
        .login-right { flex: 1; padding: 50px 40px; display: flex; flex-direction: column; justify-content: center; }
        .login-right h3 { font-weight: 700; margin-bottom: 5px; }
        .login-right .subtitle { color: #64748b; margin-bottom: 30px; }
        .form-floating .form-control { border-radius: 10px; border: 1px solid #e2e8f0; padding: 14px 12px; }
        .form-floating .form-control:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
        .btn-login { background: linear-gradient(135deg, #4f46e5, #7c3aed); border: none; border-radius: 10px; padding: 12px; font-weight: 600; width: 100%; }
        .btn-login:hover { opacity: 0.9; }
        @media (max-width: 768px) { .login-left { display: none; } }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-left">
            <i class="fas fa-graduation-cap"></i>
            <h2>Student Management System</h2>
            <p>Complete academic management platform for schools and colleges</p>
        </div>
        <div class="login-right">
            <h3>Welcome Back</h3>
            <p class="subtitle">Sign in to your account</p>

            @if($errors->any())
            <div class="alert alert-danger py-2">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                    <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-login text-white"><i class="fas fa-sign-in-alt me-2"></i>Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
