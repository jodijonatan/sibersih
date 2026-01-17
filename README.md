# Sibersih - Professional Cleaning Services Platform

## Overview

Sibersih is a comprehensive web-based platform designed to connect customers with professional cleaning services for homes, offices, and apartments in Indonesia. The application provides an intuitive interface for users to browse services, place orders, and manage their cleaning needs, while offering administrators powerful tools to manage services and orders efficiently.

## Features

### User Features

- **User Registration & Authentication**: Secure user account creation and login system
- **Service Browsing**: View detailed information about available cleaning services
- **Order Placement**: Easy booking system for cleaning services
- **Dashboard**: Personal dashboard for managing orders and account information
- **Responsive Design**: Optimized for desktop and mobile devices

### Admin Features

- **Service Management**: Add, edit, and remove cleaning services
- **Order Management**: View and update order status
- **User Management**: Manage user accounts and permissions
- **Dashboard Analytics**: Overview of services and orders

### Technical Features

- **Secure Authentication**: Password hashing and session management
- **Database Integration**: MySQL database for data persistence
- **Modern UI/UX**: Clean, professional design using Tailwind CSS
- **File Upload Support**: Image upload functionality for service photos

## Technology Stack

- **Backend**: PHP 7.0+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript
- **CSS Framework**: Tailwind CSS
- **Icons**: Font Awesome
- **Fonts**: Google Fonts (Inter)

## Installation

### Prerequisites

- PHP 7.0 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx recommended)
- Composer (optional, for dependency management)

### Setup Instructions

1. **Clone the Repository**

   ```bash
   git clone https://github.com/jodijonatan/sibersih.git
   cd sibersih
   ```

2. **Database Setup**
   - Create a new MySQL database named `sibersih_db`
   - Import the database schema from `database.sql`:
     ```sql
     mysql -u your_username -p sibersih_db < database.sql
     ```

3. **Configuration**
   - Update database credentials in `includes/config.php`:
     ```php
     $host = "localhost";
     $db = "sibersih_db";
     $user = "your_db_username";
     $pass = "your_db_password";
     ```

4. **Web Server Configuration**
   - Ensure the web server points to the project root directory
   - Make sure `uploads/` directory is writable for file uploads
   - Configure URL rewriting if using clean URLs

5. **Access the Application**
   - Open your browser and navigate to the application URL
   - Default admin credentials: Create via database or contact administrator

## Usage

### For Users

1. **Registration**: Create an account using the registration form
2. **Login**: Access your account with username and password
3. **Browse Services**: View available cleaning services on the homepage
4. **Place Orders**: Select services and schedule cleaning appointments
5. **Manage Orders**: Track order status through the user dashboard

### For Administrators

1. **Login**: Access admin panel via admin login
2. **Manage Services**: Add/edit/delete cleaning services
3. **View Orders**: Monitor and update order status
4. **User Management**: View and manage user accounts

## Project Structure

```
sibersih/
├── index.php              # Homepage/Landing page
├── login.php              # User login page
├── register.php           # User registration page
├── dashboard.php          # User dashboard
├── logout.php             # Logout functionality
├── hash.php               # Password hashing utility
├── database.sql           # Database schema
├── admin/                 # Admin panel
│   ├── jasa_add.php       # Add new service
│   ├── jasa_edit.php      # Edit service
│   ├── jasa_list.php      # List all services
│   ├── orders_edit.php    # Edit order
│   ├── orders_list.php    # List all orders
│   └── users.php          # User management
├── user/                  # User-specific pages
│   ├── fetch_jasa.php     # API for fetching services
│   ├── jasa_list.php      # User service listing
│   └── jasa_order.php     # Order placement
├── includes/              # Shared components
│   ├── config.php         # Database configuration
│   ├── header.php         # HTML header
│   ├── footer.php         # HTML footer
│   └── auth_check.php     # Authentication middleware
├── assets/                # Static assets
│   ├── hero-bg.jpg        # Hero background image
│   └── images.jpg         # Additional images
└── uploads/               # User uploaded files
```

## Database Schema

The application uses three main tables:

- **users**: Stores user account information
- **jasa**: Contains cleaning service details
- **orders**: Manages service bookings and order history

## Security Features

- Password hashing using PHP's password_hash()
- Session-based authentication
- Input sanitization and validation
- SQL injection prevention with prepared statements
- File upload restrictions and validation

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support, email halo@sibersih.id or create an issue in the repository.

## Acknowledgments

- Icons provided by Font Awesome
- Fonts by Google Fonts
- CSS framework by Tailwind CSS
- Built with PHP and MySQL

---

**Sibersih** - Making Indonesia cleaner, one home at a time.
