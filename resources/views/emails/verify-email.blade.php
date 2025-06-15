<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('auth.verify_email_title') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #111827;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 30px 0;
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }
        .logo {
            max-width: 200px;
            height: auto;
        }
        .content {
            padding: 30px;
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #E5E7EB;
            color: #111827;
            text-decoration: none;
            border-radius: 0.75rem;
            margin: 20px 0;
            font-weight: 500;
            text-align: center;
            transition: background-color 0.2s;
        }
        .button:hover {
            background-color: #D1D5DB;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6B7280;
            background-color: #ffffff;
            border-top: 1px solid #e5e7eb;
        }
        .verification-url {
            word-break: break-all;
            background-color: #F3F4F6;
            padding: 12px;
            border-radius: 0.75rem;
            font-size: 14px;
            color: #374151;
            margin: 15px 0;
        }
        .expiry-notice {
            color: #6B7280;
            font-size: 14px;
            margin-top: 20px;
        }
        .title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #111827;
            margin-bottom: 1rem;
        }
        .subtitle {
            color: #374151;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/img/logo.png') }}" alt="{{ config('app.name') }}" class="logo">
        </div>
        
        <div class="content">
            <h1 class="title">{{ __('auth.verify_email_title') }}</h1>
            
            <p class="subtitle">{{ __('auth.verify_email_greeting', ['name' => $user->name]) }}</p>
            
            <p>{{ __('auth.verify_email_text') }}</p>
            
            <div style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="button">
                    {{ __('auth.verify_email_button') }}
                </a>
            </div>
            
            <p class="expiry-notice">{{ __('auth.verify_email_expiry', ['count' => config('auth.verification.expire', 60)]) }}</p>
            
            <p>{{ __('auth.verify_email_alternative') }}</p>
            <div class="verification-url">{{ $verificationUrl }}</div>
        </div>
        
        <div class="footer">
            <p>{{ __('auth.verify_email_footer') }}</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('auth.all_rights_reserved') }}</p>
        </div>
    </div>
</body>
</html> 