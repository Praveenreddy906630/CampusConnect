@extends('layouts.app')

@section('title', 'Contact Us | CampusConnect')

@section('content')

<!-- Page Header -->
<header class="page-header bg-gradient-to-r from-primary to-red-700 text-white py-16 lg:py-20 text-center relative overflow-hidden" id="contact-header">
    
    <!-- Background Elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="floating-bg absolute top-10 left-10 w-32 h-32 bg-white rounded-full"></div>
        <div class="floating-bg absolute bottom-10 right-10 w-24 h-24 bg-white rounded-full"></div>
        <div class="floating-bg absolute top-1/2 right-1/4 w-16 h-16 bg-white rounded-full"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="header-icon text-6xl mb-4">📞</div>
        <h1 class="header-title text-3xl sm:text-4xl lg:text-5xl font-heading font-bold mb-4">
            Contact <span class="text-yellow-300">Us</span>
        </h1>
        <p class="header-subtitle text-lg sm:text-xl font-body leading-relaxed max-w-2xl mx-auto">
            Get in touch with our team for any questions, support, or assistance regarding CampusConnect
        </p>
    </div>
</header>

<main class="contact-main max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">

    <!-- Contact Information Grid -->
    <div class="contact-grid grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

        <!-- Event Related Support -->
        <div class="contact-section">
            <div class="contact-card bg-white rounded-2xl shadow-xl overflow-hidden transform hover:-translate-y-2 transition-all duration-300">
                
                <!-- Card Header -->
                <div class="card-header bg-gradient-to-r from-primary to-red-600 p-6 lg:p-8 text-white">
                    <div class="header-content text-center">
                        <div class="card-icon text-5xl mb-4">🎯</div>
                        <h2 class="card-title text-2xl lg:text-3xl font-heading font-bold mb-3">
                            Event Support
                        </h2>
                        <p class="card-subtitle font-body leading-relaxed opacity-90">
                            For any questions or issues related to specific events, competitions, or registrations
                        </p>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="card-content p-6 lg:p-8">
                    <div class="support-info space-y-6">
                        
                        <!-- Support Description -->
                        <div class="support-description">
                            <h3 class="section-title text-lg font-heading font-semibold text-text-dark mb-3 flex items-center">
                                <span class="mr-2">💡</span>
                                How We Can Help
                            </h3>
                            <ul class="help-list space-y-2">
                                <li class="help-item flex items-start text-text-light font-body">
                                    <span class="bullet w-2 h-2 bg-primary rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                    Event registration assistance
                                </li>
                                <li class="help-item flex items-start text-text-light font-body">
                                    <span class="bullet w-2 h-2 bg-primary rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                    Competition rules and guidelines
                                </li>
                                <li class="help-item flex items-start text-text-light font-body">
                                    <span class="bullet w-2 h-2 bg-primary rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                    Event schedules and venue information
                                </li>
                                <li class="help-item flex items-start text-text-light font-body">
                                    <span class="bullet w-2 h-2 bg-primary rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                    Team formation and participation queries
                                </li>
                            </ul>
                        </div>

                        <!-- Contact Action -->
                        <div class="contact-action">
                            <div class="action-content bg-red-50 rounded-xl p-6 text-center border border-red-100">
                                <h4 class="action-title text-lg font-heading font-semibold text-text-dark mb-3">
                                    Talk to Event Coordinators
                                </h4>
                                <p class="action-description text-text-light font-body mb-4 leading-relaxed">
                                    Our dedicated event coordinators are here to help you with all event-related questions and support.
                                </p>
                                <a href="{{ route('coordinators.public') }}" 
                                   class="contact-btn bg-primary text-white px-6 py-3 rounded-xl font-heading font-semibold hover:transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl inline-flex items-center">
                                    <span class="mr-2">👥</span>
                                    View All Coordinators
                                </a>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <!-- <div class="quick-stats grid grid-cols-2 gap-4">
                            <div class="stat-item text-center p-4 bg-gray-50 rounded-lg">
                                <div class="stat-number text-xl font-heading font-bold text-blue-600">15+</div>
                                <div class="stat-label text-xs text-text-light font-body">Events</div>
                            </div>
                            <div class="stat-item text-center p-4 bg-gray-50 rounded-lg">
                                <div class="stat-number text-xl font-heading font-bold text-blue-600">10+</div>
                                <div class="stat-label text-xs text-text-light font-body">Coordinators</div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Website & IT Support -->
        <div class="contact-section">
            <div class="contact-card bg-white rounded-2xl shadow-xl overflow-hidden transform hover:-translate-y-2 transition-all duration-300">
                
                <!-- Card Header -->
                <div class="card-header bg-gradient-to-r from-primary to-red-600 p-6 lg:p-8 text-white">
                    <div class="header-content text-center">
                        <div class="card-icon text-5xl mb-4">💻</div>
                        <h2 class="card-title text-2xl lg:text-3xl font-heading font-bold mb-3">
                            Website Administrators
                        </h2>
                        <p class="card-subtitle font-body leading-relaxed opacity-90">
                            For technical issues, website problems, or IT-related support and services
                        </p>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="card-content p-6 lg:p-8">
                    <div class="admin-info space-y-6">
                        
                        <!-- Support Description -->
                        <div class="support-description">
                            <h3 class="section-title text-lg font-heading font-semibold text-text-dark mb-3 flex items-center">
                                <span class="mr-2">🔧</span>
                                Technical Support
                            </h3>
                            <ul class="help-list space-y-2">
                                <li class="help-item flex items-start text-text-light font-body">
                                    <span class="bullet w-2 h-2 bg-primary rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                    Website technical issues
                                </li>
                                <li class="help-item flex items-start text-text-light font-body">
                                    <span class="bullet w-2 h-2 bg-primary rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                    Login and account problems
                                </li>
                                <li class="help-item flex items-start text-text-light font-body">
                                    <span class="bullet w-2 h-2 bg-primary rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                    IT infrastructure support
                                </li>
                                <li class="help-item flex items-start text-text-light font-body">
                                    <span class="bullet w-2 h-2 bg-primary rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                    Network and connectivity issues
                                </li>
                            </ul>
                        </div>

                        <!-- Administrators List -->
                        <div class="administrators-list space-y-6">
                            
                            <!-- Admin 1 -->
                            <div class="admin-card bg-gradient-to-r from-primary/5 to-primary/10 rounded-xl p-6 border border-primary/20">
                                <div class="admin-header flex items-start space-x-4">
                                    <div class="admin-avatar w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-primary font-heading font-bold text-lg">NP</span>
                                    </div>
                                    <div class="admin-details flex-1">
                                        <h4 class="admin-name text-lg font-heading font-bold text-text-dark mb-1">
                                            Nirad Patel
                                        </h4>
                                        <p class="admin-position text-sm font-body text-primary font-semibold mb-1">
                                            Head of Department
                                        </p>
                                        <p class="admin-department text-sm font-body text-text-light mb-3">
                                            School of Diploma Studies
                                        </p>
                                        <a href="mailto:campusconnect.corporate@gmail.com" 
                                           class="admin-email inline-flex items-center text-sm font-body text-text-dark hover:text-primary transition-colors duration-300">
                                            <span class="mr-2">📧</span>
                                            campusconnect.corporate@gmail.com
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Admin 2 -->
                            <div class="admin-card bg-gradient-to-r from-primary/5 to-primary/10 rounded-xl p-6 border border-primary/20">
                                <div class="admin-header flex items-start space-x-4">
                                    <div class="admin-avatar w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-primary font-heading font-bold text-lg">PC</span>
                                    </div>
                                    <div class="admin-details flex-1">
                                        <h4 class="admin-name text-lg font-heading font-bold text-text-dark mb-1">
                                            Mr. Panda Cord
                                        </h4>
                                        <p class="admin-position text-sm font-body text-primary font-semibold mb-1">
                                            Network Admin
                                        </p>
                                        <p class="admin-department text-sm font-body text-text-light mb-3">
                                            ITS (Information Technology Services)
                                        </p>
                                        <a href="mailto:campusconnect.corporate@gmail.com" 
                                           class="admin-email inline-flex items-center text-sm font-body text-text-dark hover:text-primary transition-colors duration-300">
                                            <span class="mr-2">📧</span>
                                            campusconnect.corporate@gmail.com
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Response Time Info -->
                        <div class="response-info bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                            <div class="flex items-center text-yellow-800">
                                <span class="mr-2">⏰</span>
                                <span class="font-body text-sm">
                                    <strong>Response Time:</strong> We typically respond within 24-48 hours during business days.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Additional Contact Information -->
    <div class="additional-contact mt-16">
        <div class="contact-footer bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-8 lg:p-12 text-center">
            <h3 class="footer-title text-2xl lg:text-3xl font-heading font-bold text-text-dark mb-4">
                Need Immediate Help?
            </h3>
            <p class="footer-subtitle text-lg text-text-light font-body mb-8 max-w-3xl mx-auto leading-relaxed">
                For urgent matters during the event days, please contact the event coordinators directly. 
                For general inquiries, feel free to reach out to our website administrators.
            </p>
            
            <!-- Quick Contact Options -->
            <div class="quick-contacts grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8 place-items-center">
    <div class="quick-contact-item bg-white rounded-xl p-6 shadow-lg transform hover:-translate-y-2 transition-all duration-300">
        <div class="contact-icon text-3xl mb-3">🏢</div>
        <h4 class="contact-title font-heading font-semibold text-text-dark mb-2">Visit Campus</h4>
        <p class="contact-detail font-body text-text-light text-sm">CampusConnect University, MANHASSET, NY</p>
    </div>
    
    <div class="quick-contact-item bg-white rounded-xl p-6 shadow-lg transform hover:-translate-y-2 transition-all duration-300">
        <div class="contact-icon text-3xl mb-3">🕒</div>
        <h4 class="contact-title font-heading font-semibold text-text-dark mb-2">Office Hours</h4>
        <p class="contact-detail font-body text-text-light text-sm">Mon - Fri: 9:00 AM - 6:00 PM</p>
    </div>
</div>


        </div>
    </div>

</main>

<!-- GSAP Animation Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Register GSAP plugins
    gsap.registerPlugin(ScrollTrigger);

    // Header Animations
    const headerTl = gsap.timeline();
    
    headerTl.from(".header-icon", {
        scale: 0,
        rotation: 180,
        duration: 0.8,
        ease: "back.out(1.7)"
    })
    .from(".header-title", {
        y: 50,
        opacity: 0,
        duration: 0.8,
        ease: "power3.out"
    }, "-=0.4")
    .from(".header-subtitle", {
        y: 30,
        opacity: 0,
        duration: 0.6,
        ease: "power2.out"
    }, "-=0.3");

    // Floating background elements
    gsap.to(".floating-bg", {
        y: -30,
        x: 20,
        rotation: 360,
        duration: 10,
        ease: "none",
        repeat: -1,
        stagger: 2
    });

    // Contact Cards Animation
    gsap.from(".contact-card", {
        opacity: 1,
        duration: 0.8,
        stagger: 0.3,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".contact-grid",
            start: "top 80%",
            toggleActions: "play none none reverse"
        }
    });

    // Card Icons Animation
    gsap.from(".card-icon", {
        scale: 0,
        rotation: 180,
        duration: 0.6,
        stagger: 0.2,
        ease: "back.out(1.7)",
        scrollTrigger: {
            trigger: ".contact-grid",
            start: "top 70%",
            toggleActions: "play none none reverse"
        }
    });

    // Card Content Animation
    gsap.from(".help-item", {
        x: -20,
        opacity: 0,
        duration: 0.5,
        stagger: 0.1,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".contact-grid",
            start: "top 60%",
            toggleActions: "play none none reverse"
        }
    });

    // Admin Cards Animation
    gsap.from(".admin-card", {
        y: 30,
        opacity: 0,
        duration: 0.6,
        stagger: 0.2,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".administrators-list",
            start: "top 80%",
            toggleActions: "play none none reverse"
        }
    });

    // Admin Avatars Animation
    gsap.from(".admin-avatar", {
        scale: 0,
        rotation: 360,
        duration: 0.6,
        stagger: 0.2,
        ease: "back.out(1.7)",
        scrollTrigger: {
            trigger: ".administrators-list",
            start: "top 75%",
            toggleActions: "play none none reverse"
        }
    });

    // Footer Section Animation
    gsap.from(".contact-footer", {
        y: 50,
        opacity: 1,
        duration: 0.8,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".additional-contact",
            start: "top 80%",
            toggleActions: "play none none reverse"
        }
    });

    gsap.from(".quick-contact-item", {
        y: 40,
        opacity: 1,
        duration: 0.6,
        stagger: 0.1,
        ease: "power2.out",
        scrollTrigger: {
            trigger: ".quick-contacts",
            start: "top 80%",
            toggleActions: "play none none reverse"
        }
    });

    // Button and Link Hover Effects
    document.querySelectorAll('.contact-btn').forEach(button => {
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

    // Email Link Hover Effects
    document.querySelectorAll('.admin-email').forEach(email => {
        email.addEventListener('mouseenter', function() {
            gsap.to(this, {
                scale: 1.05,
                duration: 0.3,
                ease: "power2.out"
            });
        });
        
        email.addEventListener('mouseleave', function() {
            gsap.to(this, {
                scale: 1,
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });

    // Card Hover Effects
    document.querySelectorAll('.contact-card, .quick-contact-item').forEach(card => {
        card.addEventListener('mouseenter', function() {
            gsap.to(this, {
                y: -8,
                duration: 0.3,
                ease: "power2.out"
            });
        });
        
        card.addEventListener('mouseleave', function() {
            gsap.to(this, {
                y: 0,
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });

});
</script>

<style>
/* Enhanced shadow effects */
.contact-card:hover, .quick-contact-item:hover {
    box-shadow: 0 20px 40px rgba(197, 1, 15, 0.1);
}

.admin-card:hover {
    background: linear-gradient(to right, rgba(197, 1, 15, 0.1), rgba(197, 1, 15, 0.15));
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

/* Email link effects */
.admin-email:hover {
    background-color: rgba(197, 1, 15, 0.1);
    padding: 4px 8px;
    border-radius: 6px;
}

/* Button effects */
.contact-btn:hover {
    box-shadow: 0 15px 30px rgba(59, 130, 246, 0.3);
}

/* Avatar hover effects */
.admin-avatar {
    transition: all 0.3s ease;
}

.admin-card:hover .admin-avatar {
    transform: scale(1.1);
    background-color: rgba(197, 1, 15, 0.3);
}
</style>

@endsection