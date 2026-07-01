<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --success: #10b981;
            --danger: #ef4444;
            --light: #f8fafc;
            --dark: #1e293b;
            --gray: #64748b;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 1rem;
        }

        .auth-card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .auth-header {
            background: var(--primary);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .auth-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .form-floating > label {
            padding-left: 1rem;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 1rem;
            border: 1px solid #d1d5db;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .toggle-password {
            cursor: pointer;
            color: var(--gray);
        }

        .toggle-password:hover {
            color: var(--dark);
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>