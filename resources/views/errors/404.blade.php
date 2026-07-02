<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - 404</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        .error-container {
            text-align: center;
            padding: 40px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            max-width: 500px;
            width: 90%;
        }
        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: #3cb815;
            line-height: 1;
            margin-bottom: 20px;
        }
        .error-message {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        .error-desc {
            font-size: 16px;
            color: #777;
            margin-bottom: 30px;
        }
        .btn-home {
            background: #3cb815;
            color: #fff;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-home:hover {
            background: #2fa810;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <h1 class="error-message">Page Not Found</h1>
        <p class="error-desc">Sorry, the page you are looking for does not exist or has been moved.</p>
        <a href="{{ url('/') }}" class="btn-home">Back to Homepage</a>
    </div>
</body>
</html>
