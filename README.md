
# 🎓 College Event Management System

<div align="center">

**A comprehensive web-based Event Management System designed for colleges to streamline event registration, coordination, analytics, and Student of the Year (SOTY) applications.**


</div>

----------


## 🎯 About

**College Event Management System** is a powerful event management platform that enables colleges to efficiently manage their events, track student participation, and analyze engagement through interactive dashboards and analytics. The system features multi-role access control, CSV data imports, automated email notifications, and comprehensive reporting capabilities.

### Key Highlights

-   🔐 Multi-role authentication (Admin, Coordinator, Student, Guest)
-   📊 Real-time analytics with interactive graphs
-   📧 Automated email notifications with password delivery
-   📁 CSV bulk import for students and events
-   🎓 Student of the Year (SOTY) application module
-   📱 Responsive design for all devices
-   📈 Event-wise registration tracking and analysis

----------

## ✨ Features

### For Administrators

-   **Complete System Control**: Manage users, coordinators, students, and events
-   **CSV Import**: Bulk import students and events data
-   **Analytics Dashboard**: View registration trends, event participation, and SOTY applications
-   **Interactive Graphs**: Analyze student registrations with bar charts, line graphs, and pie charts
-   **Registration Management**: Control registration opening/closing dates and participation limits
-   **User Management**: Create and manage coordinators and admins

### For Coordinators

-   **Event Management**: Manage assigned events and view participant lists
-   **Email Communication**: Send announcements to all registered students
-   **Registration Tracking**: Monitor real-time registration counts
-   **Participant Details**: Access enrollment numbers, names, and contact information

### For Students

-   **Easy Registration**: Register with enrollment number only
-   **Auto-filled Details**: System automatically fetches student information (Name, Class, Branch, Email, Year)
-   **Event Browsing**: View all available events categorized as Indoor, Outdoor, and Cultural
-   **SOTY Application**: Apply for Student of the Year with auto-populated CGPA and records
-   **Email Password Delivery**: Receive password via email upon account creation automatically

### Event Categories

-   🎯 **Indoor Events**: Quizzes, debates, workshops
-   🏏 **Outdoor Events**: Sports, marathons, outdoor activities
-   🎭 **Cultural Events**: Dance, music, drama performances

----------

## 👥 User Roles

**Admin**

Full system access, user management, analytics, CSV imports, event control

**Coordinator**

Manage assigned events, view participants, send emails

**Student**

Register for events, apply for SOTY, view personal dashboard

**Guest**

Limited access, view public pages and event listings

----------

## 🛠 Tech Stack

-   **Backend**: Laravel (PHP Framework)
-   **Frontend**: Blade Templates, Tailwind CSS, JavaScript
-   **Database**: MySQL
-   **Charts**: Chart.js for interactive graphs
-   **Animations**: GSAP (GreenSock Animation Platform) with ScrollTrigger
-   **Email**: PHPMailer / SMTP
-   **Version Control**: Git

----------

## 📥 Installation

### Prerequisites

Ensure you have the following installed on your system:

-   PHP >= 8.1
-   Composer
-   POSTGRESQL >= 5.7
-   Node.js & NPM
-   Git

### Step-by-Step Installation

1.  **Clone the Repository**
    
    ```bash
    git clone https://github.com/Praveenreddy906630/CampusConnect.git
    cd College-Event-Management-System
    
    ```
    
2.  **Install PHP Dependencies**
    
    ```bash
    composer install
    
    ```
    
3.  **Install NPM Dependencies**
    
    ```bash
    npm install
    
    ```
    
4.  **Create Environment File**
    
    ```bash
    cp .env.example .env
    
    ```
    
5.  **Generate Application Key**
    
    ```bash
    php artisan key:generate
    
    ```
    
6.  **Configure Database**
    
    Open `.env` file and update the following:
    
    ```env
    DB_CONNECTION=PostgreSQL
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    
    ```
    
7.  **Import Database**
    
    Import the provided SQL file to set up the complete database with tables, sample data, and configurations:
    
    ```bash
    postgresql -u your_username -p your_database_name  
    
    ```
    
    Or use phpMyAdmin:
    
    -   Open phpMyAdmin
    -   Select your database
    -   Click on "Import" tab
    -   Choose `` file
    -   Click "Go"
    
    ```bash
    npm run build
    
    ```
    
    For development:
    
    ```bash
    npm run dev
    
    ```
    
8.  **Create Storage Link**
    
    ```bash
    php artisan storage:link
    
    ```
    
9.  **Start the Development Server**
    
    ```bash
    php artisan serve
    
    ```
    
10.  **Access the Application**
    
    Open your browser and navigate to: `http://localhost:8000`
    

----------

## ⚙️ Configuration

### Email Setup (Important!)

To enable email functionality for **automatic password delivery** to students and coordinator notifications, configure SMTP settings in your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

```

#### Gmail App Password Setup

1.  Go to your Google Account settings
2.  Enable 2-Factor Authentication
3.  Navigate to **Security** > **2-Step Verification** > **App passwords**
4.  Generate a new app password for "Mail"
5.  Use this 16-character password in `MAIL_PASSWORD`

> **⚠️ Important**: When a student creates an account, their password will be **automatically emailed** to them. Ensure email configuration is complete before allowing student registrations.

### File Upload Configuration

Ensure the storage directory is writable:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache

```

----------

## 🔑 Demo Credentials

Use these credentials to test different user roles:

### 👨‍🎓 Student Account

-   **Email**: `campusconnect.corporate+student@gmail.com`
-   **Password**: `ZEBhCaXi`

### 👨‍🏫 Coordinator Account

-   **Email**: `campusconnect.corporate+co@gmail.com`
-   **Password**: `team.818`

### 👨‍💼 Admin Account

-   **Email**: `campusconnect.corporate+admin@gmail.com`
-   **Password**: `team.818`

----------

## 📸 Screenshots

View application screenshots in the **[sample images](https://github.com/Praveenreddy906630/CampusConnect/tree/main/SAMPLE%20PICTURES)** folder. Screenshots showcase:

-   Admin Dashboard with Analytics
-   Event Management Interface
-   Student Registration Flow
-   Coordinator Panel

----------

## 📚 Documentation

### Analytics & Graphs

The system provides comprehensive analytics through interactive graphs to analyze student registrations:

-   **Event-wise Registration Comparison**: Bar charts showing registrations per event
-   **Daily/Hourly Patterns**: Line charts tracking registration trends
-   **Category Analysis**: Compare participation across Indoor, Outdoor, and Cultural events
-   **SOTY Applications**: Track Student of the Year application trends

These visualizations help administrators make data-driven decisions and understand student engagement patterns.

### Database Schema

The application includes a pre-configured SQL file (`cemsys.sql`) that contains:

-   All necessary tables with proper relationships
-   Sample data for testing
-   User roles and permissions
-   Initial system configuration
-   Demo user accounts

## ⚠️ Disclaimer

This project uses images without specific copyright licensing. Please replace all images with properly licensed alternatives before commercial use.

----------

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](https://github.com/Nisarg-Vekariya/College-Event-Management-System/blob/main/LICENSE) file for details.

----------

## 👨‍💻 CampusConnect Team

**Developed with ❤️ by CampusConnect Team**

### Contact

-   **Email**: campusconnect.corporate@gmail.com
-   **GitHub**: https://github.com/Praveenreddy906630/CampusConnect

----------

## 📞 Support

For any queries or support, please contact: **campusconnect.corporate@gmail.com**

If you encounter any issues:

-   Check existing documentation
-   Review the [sample images](https://github.com/Praveenreddy906630/CampusConnect/tree/main/SAMPLE%20PICTURES) for visual guidance

----------


<div align="center">

**⭐ Star this repository if you find it helpful!**

</div>
