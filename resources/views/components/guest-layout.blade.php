<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.ondigo.ci.png') }}">
    <title>Ondigoci - Authentification</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e5a9e 0%, #2d6db5 50%, #ff6b35 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Header */
        .auth-header {
            background: linear-gradient(135deg, #1e5a9e, #2d6db5);
            padding: 20px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .auth-header-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: white;
            font-size: 24px;
            font-weight: 700;
        }

        .auth-header-logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            box-shadow: 0 2px 10px rgba(255, 107, 53, 0.3);
        }

        /* Main Content */
        .auth-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .auth-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-card h2 {
            color: #1e5a9e;
            font-weight: 700;
            margin-bottom: 10px;
            text-align: center;
        }

        .auth-card > p {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        /* Form styling */
        .form-label {
            color: #1e5a9e;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #ff6b35;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.15);
        }

        .form-control::placeholder {
            color: #999;
        }

        /* Button styling */
        .btn-primary-ondigoci {
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
            width: 100%;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
        }

        .btn-primary-ondigoci:hover {
            background: linear-gradient(135deg, #e55a28, #ff7a4a);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
            color: white;
        }

        .btn-primary-ondigoci:active {
            transform: translateY(0);
        }

        /* Checkbox styling */
        .form-check-input {
            width: 18px;
            height: 18px;
            border: 2px solid #e0e0e0;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #ff6b35;
            border-color: #ff6b35;
        }

        .form-check-label {
            color: #333;
            font-size: 14px;
            cursor: pointer;
            margin-left: 8px;
        }

        /* Links styling */
        .auth-link {
            color: #1e5a9e;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-link:hover {
            color: #ff6b35;
            text-decoration: underline;
        }

        .forgot-password-link {
            color: #ff6b35;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password-link:hover {
            color: #e55a28;
            text-decoration: underline;
        }

        .divider-text {
            text-align: center;
            color: #999;
            margin: 20px 0;
            font-size: 14px;
        }

        .sign-up-section {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .sign-up-section p {
            color: #666;
            margin-bottom: 0;
            font-size: 14px;
        }

        .sign-up-link {
            color: #1e5a9e;
            font-weight: 700;
        }

        /* Error messages */
        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        /* Success messages */
        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Footer */
        .auth-footer {
            background: rgba(0, 0, 0, 0.1);
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 13px;
        }

        .auth-footer a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .auth-footer a:hover {
            color: #ff6b35;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .auth-card {
                padding: 30px 20px;
                max-width: 100%;
            }

            .auth-header-logo {
                font-size: 20px;
            }

            .auth-card h2 {
                font-size: 22px;
            }
        }

        /* Additional spacing utilities */
        .mb-3 {
            margin-bottom: 1rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .gap-2 {
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="auth-header">
        <div class="container">
            <a href="{{ url('/') }}" class="auth-header-logo">
                <div class="auth-header-logo-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <span>ndigoci</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="auth-container">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>

    <!-- Footer -->
    <div class="auth-footer">
        <div class="container">
            <p class="mb-0">&copy; 2026 Ondigoci. Tous droits réservés. | 
                <a href="#">Confidentialité</a> | 
                <a href="#">Conditions d'utilisation</a>
            </p>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
