<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | CampusConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        .register-btn:hover,
        .verify-btn:hover {
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

        /* Verified state */
        .verified {
            background-color: #f0f9ff !important;
            border-color: #22c55e !important;
        }
        /* SweetAlert2 Custom Styling */
    .swal2-popup {
        font-family: var(--font-body);
        border-radius: 1rem;
    }
    
    .swal2-title {
        font-family: var(--font-heading);
        font-weight: 600;
        color: var(--color-text-dark);
    }
    
    .swal2-html-container {
        font-family: var(--font-body);
        color: var(--color-text-light);
    }
    
    .swal2-confirm {
        background-color: var(--color-primary) !important;
        border-radius: 0.75rem !important;
        font-family: var(--font-heading) !important;
        font-weight: 600 !important;
        padding: 0.75rem 1.5rem !important;
        box-shadow: 0 10px 15px -3px rgba(197, 1, 15, 0.3) !important;
    }
    
    .swal2-confirm:focus {
        box-shadow: 0 0 0 3px rgba(197, 1, 15, 0.3) !important;
    }
    
    .swal2-deny, .swal2-cancel {
        border-radius: 0.75rem !important;
        font-family: var(--font-heading) !important;
        font-weight: 600 !important;
        padding: 0.75rem 1.5rem !important;
    }
    </style>
</head>

<body class="bg-gradient-to-br from-primary via-red-600 to-red-800 min-h-screen flex items-center justify-center font-body bg-pattern relative py-8">

    <!-- Floating Background Elements -->
    <div class="floating-elements absolute inset-0 overflow-hidden pointer-events-none">
        <div class="floating-element absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full"></div>
        <div class="floating-element absolute top-40 right-20 w-16 h-16 bg-white/15 rounded-full"></div>
        <div class="floating-element absolute bottom-40 left-20 w-12 h-12 bg-white/20 rounded-full"></div>
        <div class="floating-element absolute bottom-20 right-10 w-24 h-24 bg-white/5 rounded-full"></div>
    </div>

    <!-- Register Container -->
    <div class="register-container bg-white shadow-2xl rounded-2xl w-full max-w-lg mx-4 overflow-hidden relative z-10">

        <!-- Header Section -->
        <div class="register-header  px-8 py-8 text-center border-b border-gray-100">
            <h1 class="brand-title text-2xl font-heading font-bold text-text-dark mb-2">
                Join <span class="text-primary">CampusConnect</span>
            </h1>
            <p class="brand-subtitle text-text-light font-body">Create your account to get started</p>
        </div>

        <!-- Register Form -->
        <div class="register-form-container px-8 py-8">
            <form id="registerForm" action="{{ route('register') }}" method="POST" class="register-form space-y-6">
                @csrf

                <!-- Enrollment Verification Section -->
                <div class="verification-section bg-gradient-to-r from-blue-50 to-primary/5 rounded-xl p-6 border border-blue-100">
                    <h3 class="verification-title text-lg font-heading font-semibold text-text-dark mb-4 flex items-center">
                        <span class="mr-2">🔍</span>
                        Enrollment Verification
                    </h3>

                    <div class="form-group">
                        <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                            <span class="label-icon mr-2">🎓</span>
                            Enrollment Number
                        </label>
                        <div class="verification-input flex gap-3">
                            <input type="text" name="enrolment_no" id="enrolment_no"
                                class="form-input flex-1 px-4 py-3 border border-gray-300 rounded-xl font-body text-text-dark transition-all duration-300 focus:border-primary focus:ring-2 focus:ring-primary/20 uppercase"
                                placeholder="Enter your enrollment number">
                            <button type="button" id="verify_btn"
                                class="verify-btn bg-primary text-white px-6 py-3 rounded-xl font-heading font-semibold hover:bg-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg relative overflow-hidden">
                                <span class="btn-text">Verify</span>
                                <div class="loading-spinner hidden absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                            </button>
                        </div>
                        <p id="enrolment_msg" class="verification-message text-sm text-red-500 mt-2 hidden flex items-center">
                            <span class="mr-2">⚠️</span>
                            <span class="message-text"></span>
                        </p>
                    </div>
                </div>

                <!-- Student Information Section -->
                <div class="student-info-section">
                    <h3 class="section-title text-lg font-heading font-semibold text-text-dark mb-6 flex items-center">
                        <span class="mr-2">👤</span>
                        Student Information
                    </h3>

                    <div class="info-grid grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Full Name -->
                        <div class="form-group sm:col-span-2">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                                <span class="label-icon mr-2">📝</span>
                                Full Name
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl bg-white font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300"
                                placeholder="Enter your full name">
                        </div>

                        <!-- Branch -->
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                                <span class="label-icon mr-2">🎯</span>
                                Branch
                            </label>
                            <input type="text" id="branch" name="branch"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl bg-white font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300"
                                placeholder="e.g. B.Tech CSE">
                        </div>

                        <!-- Semester -->
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                                <span class="label-icon mr-2">📚</span>
                                Semester
                            </label>
                            <input type="text" id="semester" name="semester"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl bg-white font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300"
                                placeholder="e.g. 6">
                        </div>

                        <!-- Gender -->
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                                <span class="label-icon mr-2">⚧️</span>
                                Gender
                            </label>
                            <input type="text" id="gender" name="gender"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl bg-white font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300"
                                placeholder="e.g. Male / Female">
                        </div>

                        <!-- School -->
                        <div class="form-group">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                                <span class="label-icon mr-2">🏫</span>
                                School
                            </label>
                            <input type="text" id="school" name="school"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl bg-white font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300"
                                placeholder="e.g. School of Computer Science">
                        </div>

                        <!-- Email -->
                        <div class="form-group sm:col-span-2">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                                <span class="label-icon mr-2">📧</span>
                                Email Address
                            </label>
                            <input type="email" id="email" name="email" required
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl bg-white font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300"
                                placeholder="Enter your email address">
                        </div>

                        <!-- Password -->
                        <div class="form-group sm:col-span-1">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                                <span class="label-icon mr-2">🔒</span>
                                Password
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                    class="form-input w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl bg-white font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300"
                                    placeholder="Create password (min 6 chars)">
                                <button type="button" onclick="togglePasswordVisibility('password', 'toggleIcon1')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-primary transition-colors focus:outline-none">
                                    <span id="toggleIcon1">👁️</span>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group sm:col-span-1">
                            <label class="form-label block font-heading font-semibold text-text-dark mb-2">
                                <span class="label-icon mr-2">🔑</span>
                                Confirm Password
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="form-input w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl bg-white font-body text-text-dark focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all duration-300"
                                    placeholder="Confirm password">
                                <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'toggleIcon2')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-primary transition-colors focus:outline-none">
                                    <span id="toggleIcon2">👁️</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="registerBtn"
                    class="register-btn w-full bg-primary text-white py-4 px-6 rounded-xl font-heading font-semibold text-lg hover:bg-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg relative overflow-hidden">
                    <span class="btn-text">Create Account</span>
                    <div class="loading-spinner hidden absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>
                </button>
            </form>

            <!-- Login Link -->
            <div class="login-section text-center mt-8 pt-6 border-t border-gray-100">
                <p class="login-text font-body text-text-light">
                    Already have an account?
                    <a href="{{ route('login') }}" class="login-link text-primary hover:text-red-700 font-semibold transition-colors duration-300 ml-1">
                        Sign In
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div class="modal-content bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4 text-center transform scale-95">
            <div class="modal-header mb-6">
                <h2 class="modal-title text-2xl font-heading font-bold text-primary mb-2">
                    Account Created Successfully!
                </h2>
                <p class="modal-subtitle text-text-light font-body leading-relaxed">
                    Your account has been created successfully.<br>
                    Please check your email for login credentials.
                </p>
            </div>

            <div class="modal-actions">
                <button onclick="closeModal()" id="modalCloseBtn"
                    class="modal-btn bg-primary text-white px-8 py-3 rounded-xl font-heading font-semibold hover:bg-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                    Continue
                </button>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // First make sure the buttons are visible
    gsap.set("#registerBtn", {
        opacity: 1,
        y: 0
    });
    gsap.set("#verify_btn", {
        opacity: 1,
        y: 0
    });

    // GSAP Animations
    const tl = gsap.timeline();

    // Container entrance animation
    tl.from(".register-container", {
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
        .from(".verification-section", {
            y: 30,
            opacity: 0,
            duration: 0.6,
            ease: "power2.out"
        }, "-=0.1")
        .from(".student-info-section", {
            y: 30,
            opacity: 0,
            duration: 0.6,
            ease: "power2.out"
        }, "-=0.3")
        .from(".form-group", {
            y: 20,
            opacity: 0,
            duration: 0.4,
            stagger: 0.05,
            ease: "power2.out"
        }, "-=0.4")
        .from(".register-btn", {
            y: 20,
            opacity: 0, // This animates FROM opacity 0 TO current opacity
            duration: 0.5,
            ease: "back.out(1.7)"
        }, "-=0.2")
        .from(".login-section", {
            y: 15,
            opacity: 0,
            duration: 0.4,
            ease: "power2.out"
        }, "-=0.1");

    // Form input animations
    document.querySelectorAll('.form-input').forEach(input => {
        if (!input.readOnly) {
            input.addEventListener('focus', function() {
                gsap.to(this, {
                    scale: 1.02,
                    duration: 0.3,
                    ease: "power2.out"
                });
                gsap.to(this.previousElementSibling, {
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
        }
    });

    // Button hover effects
    document.querySelectorAll('.verify-btn, .register-btn').forEach(button => {
        button.addEventListener('mouseenter', function() {
            gsap.to(this, {
                scale: 1.05,
                y: -2,
                duration: 0.3,
                ease: "power2.out"
            });
        });

        button.addEventListener('mouseleave', function() {
            gsap.to(this, {
                scale: 1,
                y: 0,
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });

    // Force uppercase while typing
    document.getElementById('enrolment_no').addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Verify enrollment number
    document.getElementById('verify_btn').addEventListener('click', function() {
        const enrolmentInput = document.getElementById('enrolment_no');
        const enrolment = enrolmentInput.value.trim().toUpperCase();
        enrolmentInput.value = enrolment; // keep uppercase in input

        const verifyBtn = this;
        const btnText = verifyBtn.querySelector('.btn-text');
        const spinner = verifyBtn.querySelector('.loading-spinner');
        const messageDiv = document.getElementById('enrolment_msg');
        const messageText = messageDiv.querySelector('.message-text');

        if (enrolment.length > 0) {
            // Show loading state
            btnText.style.opacity = '0';
            spinner.classList.remove('hidden');
            verifyBtn.disabled = true;
            messageDiv.classList.add('hidden');

            axios.post("{{ url('/get-student-details') }}", {
                    enrolment_no: enrolment
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    btnText.style.opacity = '1';
                    spinner.classList.add('hidden');
                    verifyBtn.disabled = false;

                    if (response.data.success) {
                        let s = response.data.data;

                        // Animate form population
                        gsap.to('.info-grid .form-input', {
                            backgroundColor: '#f0f9ff',
                            borderColor: '#22c55e',
                            duration: 0.5,
                            stagger: 0.1
                        });

                        // Populate fields with animation
                        setTimeout(() => {
                            document.getElementById('name').value = s.full_name;
                            document.getElementById('branch').value = s.program_code;
                            document.getElementById('semester').value = s.semester;
                            document.getElementById('gender').value =
                                (s.gender === 'M') ? 'Male' : (s.gender === 'F') ? 'Female' : s.gender;
                            document.getElementById('school').value = s.school_name;
                            document.getElementById('email').value = s.email;

                            // Success animation
                            gsap.from('.info-grid .form-input', {
                                scale: 1.05,
                                duration: 0.3,
                                stagger: 0.05,
                                ease: "power2.out"
                            });
                        }, 100);

                        // Success feedback
                        btnText.textContent = 'Verified!';
                        gsap.to(verifyBtn, {
                            backgroundColor: "#22c55e",
                            duration: 0.3
                        });

                        // Add SweetAlert2 success notification
                        Swal.fire({
                            title: 'Verification Successful',
                            text: 'Your enrollment has been verified successfully!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                            customClass: {
                                popup: 'swal2-popup'
                            }
                        });

                        setTimeout(() => {
                            btnText.textContent = 'Verify';
                            gsap.to(verifyBtn, {
                                backgroundColor: "#c5010f",
                                duration: 0.3
                            });
                        }, 2000);

                    } else {
                        showError(response.data.message);
                    }
                })
                .catch(() => {
                    btnText.style.opacity = '1';
                    spinner.classList.add('hidden');
                    verifyBtn.disabled = false;
                    showError("Error verifying enrollment number.");
                });

        } else {
            showError("Please enter an enrollment number.");
        }

        function showError(message) {
            messageText.textContent = message;
            messageDiv.classList.remove('hidden');
            gsap.from(messageDiv, {
                x: -20,
                opacity: 0,
                duration: 0.5
            });

            // Shake animation
            gsap.to(enrolmentInput, {
                x: -5,
                duration: 0.1,
                yoyo: true,
                repeat: 5,
                ease: "power2.inOut"
            });
            
            // Add SweetAlert2 error notification
            Swal.fire({
                title: 'Verification Failed',
                text: message,
                icon: 'error',
                confirmButtonText: 'Try Again',
                customClass: {
                    confirmButton: 'swal2-confirm'
                }
            });
        }
    });


    function togglePasswordVisibility(fieldId, iconId) {
        const input = document.getElementById(fieldId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = '🙈';
        } else {
            input.type = 'password';
            icon.textContent = '👁️';
        }
    }

    // Handle form submission
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const registerBtn = document.getElementById('registerBtn');
        const btnText = registerBtn.querySelector('.btn-text');
        const spinner = registerBtn.querySelector('.loading-spinner');

        const pass = document.getElementById('password').value;
        const passConfirm = document.getElementById('password_confirmation').value;

        if (!pass || pass.length < 6) {
            Swal.fire({
                title: 'Validation Error',
                text: 'Password must be at least 6 characters long.',
                icon: 'warning',
                confirmButtonText: 'OK',
                customClass: { confirmButton: 'swal2-confirm' }
            });
            return;
        }

        if (pass !== passConfirm) {
            Swal.fire({
                title: 'Validation Error',
                text: 'Password and Confirm Password do not match.',
                icon: 'warning',
                confirmButtonText: 'OK',
                customClass: { confirmButton: 'swal2-confirm' }
            });
            return;
        }

        // Show loading state
        btnText.style.opacity = '0';
        spinner.classList.remove('hidden');
        registerBtn.disabled = true;

        let formData = new FormData(this);

        axios.post(this.action, formData)
            .then(response => {
                console.log("Response:", response.data);

                btnText.style.opacity = '1';
                spinner.classList.add('hidden');

                if (response.data.success) {
                    // Success animation
                    btnText.textContent = 'Success!';
                    gsap.to(registerBtn, {
                        backgroundColor: "#22c55e",
                        scale: 1,
                        duration: 0.3
                    });

                    // Show success with SweetAlert2
                    Swal.fire({
                        title: 'Account Created Successfully!',
                        text: 'Your account has been created successfully. You can now sign in using your email and password.',
                        icon: 'success',
                        confirmButtonText: 'Sign In Now',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('login') }}";
                        }
                    });
                } else {
                    registerBtn.disabled = false;
                    btnText.textContent = 'Create Account';
                    gsap.to(registerBtn, {
                        backgroundColor: "#c5010f",
                        duration: 0.3
                    });
                    
                    // Replace alert with SweetAlert2
                    Swal.fire({
                        title: 'Registration Failed',
                        text: response.data.message || 'Please check your information and try again.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'swal2-confirm'
                        }
                    });
                }
            })
            .catch(error => {
                console.error("Error:", error);
                btnText.style.opacity = '1';
                spinner.classList.add('hidden');
                registerBtn.disabled = false;
                btnText.textContent = 'Create Account';
                gsap.to(registerBtn, {
                    backgroundColor: "#c5010f",
                    duration: 0.3
                });

                let errMsg = "There was an error processing your registration. Please try again.";
                if (error.response && error.response.data) {
                    if (error.response.data.message) {
                        errMsg = error.response.data.message;
                    } else if (error.response.data.errors) {
                        errMsg = Object.values(error.response.data.errors).flat().join(" ");
                    }
                }
                
                // Replace alert with SweetAlert2
                Swal.fire({
                    title: 'Registration Failed',
                    text: errMsg,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    }
                });
            });
    });

    // Link hover effects
    document.querySelectorAll('.login-link').forEach(link => {
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

// Close modal function - can be removed since we're using SweetAlert2 instead
function closeModal() {
    const modal = document.getElementById('successModal');
    gsap.to(modal.querySelector('.modal-content'), {
        scale: 0.8,
        y: 50,
        duration: 0.3,
        onComplete: () => modal.classList.add('hidden')
    });
}
    </script>
</body>

</html>