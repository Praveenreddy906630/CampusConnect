<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CampusConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"></script>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <script>
        // Extend Tailwind config to support custom variables
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: 'var(--color-primary)',
                        background: 'var(--color-background)',
                        'text-dark': 'var(--color-text-dark)',
                        'text-light': 'var(--color-text-light)',
                        white: 'var(--color-white)',
                        black: 'var(--color-black)'
                    },
                    fontFamily: {
                        heading: 'var(--font-heading)',
                        body: 'var(--font-body)'
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --color-primary: #c5010f;
            --color-background: #ffffff;
            --color-text-dark: #333333;
            --color-text-light: #666666;
            --color-white: #ffffff;
            --color-black: #000000;
            --font-heading: 'Poppins', sans-serif;
            --font-body: 'Roboto', sans-serif;
        }

        body {
            font-family: var(--font-body);
        }

        /* Ensure typed and pre-filled text in form inputs is always dark and clearly visible */
        input, select, textarea, .form-input {
            color: #1a1a1a !important;
            -webkit-text-fill-color: #1a1a1a !important;
            opacity: 1 !important;
        }

        input:read-only, input:disabled, .form-input:read-only, .form-input:disabled {
            color: #1a1a1a !important;
            -webkit-text-fill-color: #1a1a1a !important;
            background-color: #f8fafc !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #1a1a1a !important;
            -webkit-box-shadow: 0 0 0px 1000px #f0f9ff inset !important;
        }

        /* Custom animations */
        .form-input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(197, 1, 15, 0.1);
        }

        .login-btn:hover {
            box-shadow: 0 15px 30px rgba(197, 1, 15, 0.3);
        }

        /* Background pattern */
        .bg-pattern {
            background-image:
                radial-gradient(circle at 25% 25%, rgba(197, 1, 15, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(197, 1, 15, 0.05) 0%, transparent 50%);
        }

        /* Floating elements */
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(2) {
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        /* Loading animation */
        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* SweetAlert2 custom theme */
        .swal2-popup {
            border-radius: 16px !important;
            font-family: var(--font-body) !important;
        }

        .swal2-title {
            font-family: var(--font-heading) !important;
            color: var(--color-text-dark) !important;
            font-weight: 600 !important;
        }

        .swal2-html-container {
            color: var(--color-text-light) !important;
        }

        .swal2-confirm {
            background-color: var(--color-primary) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 10px 24px !important;
            font-weight: 600 !important;
        }

        .swal2-cancel {
            background-color: #f0f0f0 !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 10px 24px !important;
            color: var(--color-text-dark) !important;
            font-weight: 600 !important;
        }

        .swal2-success .swal2-success-ring {
            border-color: var(--color-primary) !important;
        }

        .swal2-success [class^=swal2-success-line] {
            background-color: var(--color-primary) !important;
        }

        .swal2-icon.swal2-error {
            border-color: var(--color-primary) !important;
        }

        .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
            background-color: var(--color-primary) !important;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-primary via-red-600 to-red-800 min-h-screen flex items-center justify-center font-body bg-pattern relative">

    <!-- Floating Background Elements -->
    <div class="floating-elements absolute inset-0 overflow-hidden pointer-events-none">
        <div class="floating-element absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full"></div>
        <div class="floating-element absolute top-40 right-20 w-16 h-16 bg-white/15 rounded-full"></div>
        <div class="floating-element absolute bottom-40 left-20 w-12 h-12 bg-white/20 rounded-full"></div>
        <div class="floating-element absolute bottom-20 right-10 w-24 h-24 bg-white/5 rounded-full"></div>
    </div>

    <!-- Login Container -->
    <div class="login-container bg-white shadow-2xl rounded-2xl w-full max-w-md mx-4 overflow-hidden relative z-10">

        <!-- Header Section -->
        <div class="login-header px-8 py-8 text-center border-b border-gray-100">
            <h1 class="brand-title text-2xl font-heading font-bold text-text-dark mb-2">
                Welcome to <span class="text-primary">CampusConnect</span>
            </h1>
            <p class="brand-subtitle text-text-light font-body">Sign in to access your account</p>
        </div>

        <!-- Login Form -->
        <div class="login-form-container px-8 py-8">
            <form id="loginForm" action="{{ route('login') }}" method="POST" class="login-form space-y-6">
                @csrf

                <!-- Email Field -->
                <div class="form-group">
                    <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                        <span class="label-icon mr-2">📧</span>
                        Email Address
                    </label>
                    <input type="email" name="email" required
                        class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl font-body text-text-dark transition-all duration-300 focus:border-primary focus:ring-2 focus:ring-primary/20"
                        placeholder="Enter your email address">
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                        <span class="label-icon mr-2">🔒</span>
                        Password
                    </label>
                    <div class="password-container relative">
                        <input type="password" name="password" id="passwordInput" required
                            class="form-input w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl font-body text-text-dark transition-all duration-300 focus:border-primary focus:ring-2 focus:ring-primary/20"
                            placeholder="Enter your password">
                        <button type="button" id="togglePassword"
                            class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 text-text-light hover:text-primary transition-colors duration-300">
                            <span class="toggle-icon">👁️</span>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="remember-section flex items-center justify-between">
                    <label class="remember-label flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" id="remember"
                            class="remember-checkbox w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary focus:ring-2 transition-all duration-300">
                        <span class="remember-text ml-2 font-body text-text-dark">Remember me</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="loginBtn"
                    class="login-btn w-full bg-primary text-white py-4 px-6 rounded-xl font-heading font-semibold text-lg hover:bg-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg relative flex items-center justify-center overflow-hidden">
                    <span class="btn-text">Sign In</span>
                    <div class="loading-spinner hidden absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
                </button>


            </form>

            <!-- Register Link -->
            <div class="register-section text-center mt-8 pt-6 border-t border-gray-100">
                <p class="register-text font-body text-text-light">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="register-link text-primary hover:text-red-700 font-semibold transition-colors duration-300 ml-1">
                        Create Account
                    </a>
                </p>
            </div>

            <!-- Error Message -->
            <div id="loginError" class="error-message bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg mt-6 hidden">
                <div class="flex items-center">
                    <span class="error-icon text-xl mr-3">⚠️</span>
                    <span class="error-text font-body"></span>
                </div>
            </div>

            <!-- Success Message -->
            <div id="loginSuccess" class="success-message bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg mt-6 hidden">
                <div class="flex items-center">
                    <span class="success-icon text-xl mr-3">✅</span>
                    <span class="success-text font-body">Login successful! Redirecting...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Initialize SweetAlert2 with custom theme
            const swalWithTheme = Swal.mixin({
                customClass: {
                    popup: 'swal2-popup',
                    title: 'swal2-title',
                    htmlContainer: 'swal2-html-container',
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                },
                buttonsStyling: false
            });

            // First make sure the login button is visible
            gsap.set("#loginBtn", {
                opacity: 1,
                y: 0
            });

            // GSAP Animations
            const tl = gsap.timeline();

            // Container entrance animation
            tl.from(".login-container", {
                    scale: 0.8,
                    opacity: 0,
                    y: 50,
                    duration: 0.8,
                    ease: "back.out(1.7)"
                })
                .from(".brand-icon", {
                    scale: 0,
                    rotation: 180,
                    duration: 0.6,
                    ease: "back.out(1.7)"
                }, "-=0.4")
                .from(".brand-title", {
                    y: 20,
                    opacity: 0,
                    duration: 0.6,
                    ease: "power2.out"
                }, "-=0.3")
                .from(".brand-subtitle", {
                    y: 15,
                    opacity: 0,
                    duration: 0.5,
                    ease: "power2.out"
                }, "-=0.2")
                .from(".form-group", {
                    y: 30,
                    opacity: 0,
                    duration: 0.5,
                    stagger: 0.1,
                    ease: "power2.out"
                }, "-=0.1")
                .from(".remember-section", {
                    y: 20,
                    opacity: 0,
                    duration: 0.5,
                    ease: "power2.out"
                }, "-=0.2")
                .from(".login-btn", {
                    y: 20,
                    opacity: 0,
                    duration: 0.5,
                    ease: "back.out(1.7)"
                }, "-=0.1")
                .from(".register-section", {
                    y: 15,
                    opacity: 0,
                    duration: 0.4,
                    ease: "power2.out"
                }, "-=0.1");

            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle icon
                const icon = this.querySelector('.toggle-icon');
                icon.textContent = type === 'password' ? '👁️' : '🙈';

                // Animate toggle
                gsap.to(this, {
                    scale: 0.8,
                    duration: 0.1,
                    yoyo: true,
                    repeat: 1
                });
            });

            // Form input animations
            document.querySelectorAll('.form-input').forEach(input => {
                input.addEventListener('focus', function() {
                    gsap.to(this, {
                        scale: 1.02,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                    const label = this.closest('.form-group').querySelector('.form-label');
                    gsap.to(label, {
                        color: "#c5010f",
                        duration: 0.3
                    });

                });

                input.addEventListener('blur', function() {
                    gsap.to(this, {
                        scale: 1,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                    gsap.to(this.previousElementSibling, {
                        color: "#333333",
                        duration: 0.3
                    });
                });
            });

            // Button hover effects
            const loginBtn = document.getElementById('loginBtn');
            loginBtn.addEventListener('mouseenter', function() {
                gsap.to(this, {
                    scale: 1.05,
                    y: -2,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            loginBtn.addEventListener('mouseleave', function() {
                gsap.to(this, {
                    scale: 1,
                    y: 0,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            // Form validation function
            function validateForm() {
                const email = document.querySelector('input[name="email"]').value;
                const password = document.getElementById('passwordInput').value;

                if (!email) {
                    swalWithTheme.fire({
                        icon: 'error',
                        title: 'Email Required',
                        text: 'Please enter your email address',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }

                if (!password) {
                    swalWithTheme.fire({
                        icon: 'error',
                        title: 'Password Required',
                        text: 'Please enter your password',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }

                // Basic email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    swalWithTheme.fire({
                        icon: 'error',
                        title: 'Invalid Email',
                        text: 'Please enter a valid email address',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }

                return true;
            }

            // Form submission with enhanced animations
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                e.preventDefault();

                // Validate form before submission
                if (!validateForm()) {
                    return;
                }

                const loginBtn = document.getElementById('loginBtn');
                const btnText = loginBtn.querySelector('.btn-text');
                const spinner = loginBtn.querySelector('.loading-spinner');
                const errorDiv = document.getElementById('loginError');
                const successDiv = document.getElementById('loginSuccess');

                // Hide previous messages
                errorDiv.classList.add('hidden');
                successDiv.classList.add('hidden');

                // Show loading state
                btnText.style.opacity = '0';
                spinner.classList.remove('hidden');
                loginBtn.disabled = true;

                gsap.to(loginBtn, {
                    scale: 0.98,
                    duration: 0.1
                });

                let formData = new FormData(this);

                axios.post(this.action, formData)
                    .then(response => {
                        if (response.data.success) {
                            // Success animation
                            btnText.style.opacity = '1';
                            spinner.classList.add('hidden');
                            btnText.textContent = 'Success!';

                            gsap.to(loginBtn, {
                                backgroundColor: "#22c55e",
                                scale: 1,
                                duration: 0.3
                            });

                            // Show SweetAlert2 success message
                            swalWithTheme.fire({
                                icon: 'success',
                                title: 'Login Successful!',
                                text: 'Redirecting to your dashboard...',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            });

                            // Redirect after delay - use the redirect URL from server response
                            setTimeout(() => {
                                // Use the redirect URL from response or default to home
                                const redirectUrl = response.data.redirect || "{{ url('/') }}";
                                window.location.href = redirectUrl;
                            }, 1500);
                        } else {
                            showError(response.data.message || "Invalid credentials");
                        }
                    })
                    .catch(error => {
                        let errorMessage = "Login failed. Please try again.";

                        // More specific error messages based on response
                        if (error.response) {
                            if (error.response.status === 401) {
                                errorMessage = "Invalid email or password. Please try again.";
                            } else if (error.response.status === 422) {
                                errorMessage = "Please check your input and try again.";
                            } else if (error.response.status >= 500) {
                                errorMessage = "Server error. Please try again later.";
                            }
                        }

                        showError(errorMessage);
                    });

                function showError(message) {
                    // Reset button
                    btnText.style.opacity = '1';
                    spinner.classList.add('hidden');
                    btnText.textContent = 'Sign In';
                    loginBtn.disabled = false;

                    gsap.to(loginBtn, {
                        backgroundColor: "#c5010f",
                        scale: 1,
                        duration: 0.3
                    });

                    // Show SweetAlert2 error message
                    swalWithTheme.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: message,
                        confirmButtonText: 'Try Again'
                    });

                    // Shake animation for form
                    gsap.to('.login-container', {
                        x: -10,
                        duration: 0.1,
                        yoyo: true,
                        repeat: 5,
                        ease: "power2.inOut"
                    });
                }
            });

            // Link hover effects
            document.querySelectorAll('.register-link').forEach(link => {
                link.addEventListener('mouseenter', function() {
                    gsap.to(this, {
                        scale: 1.05,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });

                link.addEventListener('mouseleave', function() {
                    gsap.to(this, {
                        scale: 1,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });
            });
        });
    </script>
</body>

</html>