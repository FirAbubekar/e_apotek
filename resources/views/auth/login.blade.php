<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Apotekku</title>
    <style>
        :root {
            --primary-color: #0d9488;
            --primary-hover: #0f766e;
            --bg-color: #f0fdfa;
            --text-color: #1f2937;
            --border-color: #e5e7eb;
            --card-bg: #ffffff;
            --error-color: #ef4444;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background-color: var(--card-bg);
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(13, 148, 136, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
            box-sizing: border-box;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            color: var(--primary-color);
            font-size: 2rem;
            margin: 0 0 0.5rem 0;
            font-weight: 700;
        }

        .login-header p {
            color: #6b7280;
            margin: 0;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.9rem;
            color: #4b5563;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 1rem;
            box-sizing: border-box;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.2);
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .form-check-input {
            margin-top: 0;
            margin-right: 0.5rem;
            cursor: pointer;
        }

        .form-check-label {
            font-size: 0.9rem;
            color: #4b5563;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
            background-color: #fee2e2;
            color: var(--error-color);
            border: 1px solid #f87171;
            font-size: 0.9rem;
        }
        .alert ul {
            margin: 0;
            padding-left: 1.5rem;
        }
    </style>
    <!-- Include Inter font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h1>Apotekku</h1>
            <p>Welcome back! Please login to your account.</p>
        </div>

        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="username">User</label>
                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="user">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="••••••••">
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn-primary">
                Sign In
            </button>
        </form>
    </div>

</body>
</html>
