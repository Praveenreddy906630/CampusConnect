<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your CampusConnect Account Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f8f9fa;
        }

        /* Main container */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .email-header {
            background: linear-gradient(135deg, #c5010f 0%, #a0010c 100%);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }

        .logo {
            font-family: 'Poppins', sans-serif;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .tagline {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 300;
        }

        /* Content area */
        .email-content {
            padding: 40px 30px;
        }

        .greeting {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            font-weight: 600;
            color: #333333;
            margin-bottom: 20px;
        }

        .welcome-message {
            font-size: 16px;
            color: #666666;
            margin-bottom: 30px;
            line-height: 1.7;
        }

        /* Credentials box */
        .credentials-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 4px solid #c5010f;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .credentials-title {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            font-weight: 600;
            color: #333333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .credentials-title::before {
            content: "🔐";
            margin-right: 10px;
            font-size: 20px;
        }

        .credential-item {
            display: flex;
            margin-bottom: 12px;
            align-items: center;
        }

        .credential-label {
            font-weight: 500;
            color: #333333;
            min-width: 80px;
            display: flex;
            align-items: center;
        }

        .credential-label::before {
            content: "✉️";
            margin-right: 8px;
            font-size: 16px;
        }

        .credential-item:last-child .credential-label::before {
            content: "🔑";
        }

        .credential-value {
            background: #ffffff;
            padding: 8px 12px;
            border-radius: 4px;
            font-family: 'Roboto', monospace;
            font-size: 14px;
            color: #333333;
            border: 1px solid #dee2e6;
            flex: 1;
            margin-left: 10px;
        }

        /* Action button */
        .action-section {
            text-align: center;
            margin: 35px 0;
        }

        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #c5010f 0%, #a0010c 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(197, 1, 15, 0.3);
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(197, 1, 15, 0.4);
        }

        /* Important notice */
        .notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }

        .notice-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #856404;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .notice-title::before {
            content: "⚠️";
            margin-right: 10px;
            font-size: 18px;
        }

        .notice-text {
            color: #856404;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Footer */
        .email-footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }

        .footer-text {
            color: #666666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .footer-links {
            margin-top: 20px;
        }

        .footer-links a {
            color: #c5010f;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        /* Responsive design */
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                box-shadow: none;
            }

            .email-header,
            .email-content,
            .email-footer {
                padding: 25px 20px;
            }

            .logo {
                font-size: 28px;
            }

            .greeting {
                font-size: 20px;
            }

            .credentials-box {
                padding: 20px 15px;
            }

            .credential-item {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 15px;
            }

            .credential-value {
                margin-left: 0;
                margin-top: 5px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="logo">CampusConnect</div>
            <div class="tagline">Welcome to Your Journey</div>
        </div>

        <!-- Content -->
        <div class="email-content">
            <div class="greeting">Hello {{ $studentName }}!</div>
            
            <div class="welcome-message">
                We're excited to welcome you to <strong>CampusConnect</strong>! Your account has been successfully created and you're all set to begin your journey with us.
            </div>

            <!-- Credentials Box -->
            <div class="credentials-box">
                <div class="credentials-title">Your Login Credentials</div>
                <div class="credential-item">
                    <div class="credential-label">Email:</div>
                    <div class="credential-value">{{ $studentEmail }}</div>
                </div>
                <div class="credential-item">
                    <div class="credential-label">Password:</div>
                    <div class="credential-value">{{ $studentPassword }}</div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="action-section">
                <a href="{{ $loginUrl }}" class="login-button">Login to Your Account</a>
            </div>

            <!-- Important Notice -->
            <div class="notice">
                <div class="notice-title">Important Security Notice</div>
                <div class="notice-text">
                    For your security, please login and change your password immediately after your first login. We recommend using a strong, unique password that you haven't used elsewhere.
                </div>
            </div>

            <div class="welcome-message">
                If you have any questions or need assistance, please don't hesitate to reach out to our support team. We're here to help make your experience with CampusConnect exceptional.
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-text">
                This email was sent to {{ $studentEmail }} because an account was created for CampusConnect.
            </div>
            <div class="footer-links">
                <a href="{{ $loginUrl }}">Support</a>
                <a href="{{ $loginUrl }}">Privacy Policy</a>
                <a href="{{ $loginUrl }}">Terms of Service</a>
            </div>
            <div class="footer-text" style="margin-top: 20px;">
                © 2025 CampusConnect Team. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>