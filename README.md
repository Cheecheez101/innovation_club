# Elite Academy Innovation Club Management System

A comprehensive web-based management system for the Elite Academy Innovation Club, designed to streamline club operations, member management, event coordination, attendance tracking, and project monitoring. Built with modern PHP and MySQL technologies.

## 🚀 Features

### Core Functionality
- **🔐 Secure Authentication**: Role-based access control with session management
- **👥 Member Management**: Complete CRUD operations for club members
- **📅 Event Management**: Create, update, and manage club events with registration
- **📊 Attendance Tracking**: Automated attendance marking and reporting
- **💡 Project Management**: Organize innovation projects with team assignments
- **📈 Reporting System**: Generate comprehensive reports and analytics
- **📱 Responsive Dashboard**: Real-time statistics and quick actions

### Advanced Features
- **🔍 Advanced Search & Filtering**: Find members, events, and projects instantly
- **📧 Email Notifications**: Automated notifications for events and updates
- **📊 Data Export**: Export data to CSV and PDF formats
- **🎨 Modern UI/UX**: Clean, responsive design with intuitive navigation
- **🔒 Security First**: CSRF protection, input validation, and secure coding practices
- **⚡ Performance Optimized**: Fast loading with caching and optimization

## 📋 System Requirements

### Minimum Requirements
- **PHP**: 7.4.0 or higher
- **MySQL**: 5.7.0 or higher
- **Web Server**: Apache 2.4+ / Nginx 1.16+
- **Memory**: 128MB RAM minimum
- **Storage**: 50MB free space

### Recommended Requirements
- **PHP**: 8.0+ with OPcache enabled
- **MySQL**: 8.0+ with InnoDB
- **Web Server**: Apache 2.4+ with mod_rewrite
- **Memory**: 256MB RAM or more
- **Storage**: 100MB+ free space

### PHP Extensions Required
- `pdo` and `pdo_mysql`
- `mysqli`
- `json`
- `mbstring`
- `curl`
- `gd` (for image processing)
- `fileinfo`

## 🛠️ Installation & Setup

### Quick Start (XAMPP/WAMP)
1. **Download & Extract**
   ```bash
   # Extract files to htdocs directory
   # Example: C:\xampp\htdocs\innovation_club
   ```

2. **Database Setup**
   ```sql
   -- Create database
   CREATE DATABASE innovation_club_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

   -- Import schema
   -- Use phpMyAdmin or command line to import database/schema.sql
   ```

3. **Configuration**
   ```php
   // Update database credentials in app/config/database.php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'innovation_club_db');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

4. **Web Server Configuration**
   - Ensure `mod_rewrite` is enabled in Apache
   - Point document root to the `public/` directory
   - Restart web server

5. **Access Application**
   ```
   URL: http://localhost/innovation_club/public
   Default Admin Login:
   Username: admin
   Password: password123
   ```

### Advanced Installation (Production)

#### Using Composer (Recommended)
```bash
# Install dependencies
composer install

# Generate autoloader
composer dump-autoload --optimize

# Run database migrations (if available)
php artisan migrate
```

#### Manual Installation
1. Download and extract the project files
2. Configure web server virtual host
3. Set proper file permissions
4. Configure environment variables

## 📁 Project Structure

```
innovation-club/
├── 📁 public/                 # 🌐 Web root (publicly accessible)
│   ├── index.php             # 🎯 Front controller
│   ├── .htaccess             # 🔒 Security & URL rewriting
│   ├── 📁 assets/            # 🎨 CSS, JS, images, fonts
│   │   ├── 📁 css/          # 🎨 Stylesheets
│   │   ├── 📁 js/           # ⚡ JavaScript files
│   │   └── 📁 images/       # 🖼️ Static images
│   └── 📁 uploads/           # 📎 User uploads
├── 📁 app/                   # 🏗️ Application core
│   ├── 📁 config/            # ⚙️ Configuration files
│   ├── 📁 controllers/       # 🎮 MVC controllers
│   ├── 📁 models/            # 📊 MVC models
│   ├── 📁 views/             # 👁️ MVC views & templates
│   │   ├── 📁 layouts/      # 📐 Layout templates
│   │   ├── 📁 auth/         # 🔐 Authentication views
│   │   ├── 📁 dashboard/    # 📊 Dashboard views
│   │   └── 📁 members/      # 👥 Member views
│   ├── 📁 core/              # 🔧 Core classes
│   │   ├── App.php          # 🚀 Main application class
│   │   ├── Database.php     # 💾 Database abstraction
│   │   ├── Controller.php   # 🎮 Base controller
│   │   └── Model.php        # 📋 Base model
│   └── 📁 helpers/           # 🛠️ Helper functions
├── 📁 database/              # 🗄️ Database files
│   ├── schema.sql           # 📝 Database schema
│   └── 📁 migrations/       # 🔄 Database migrations
├── 📁 storage/               # 💾 Storage (logs, cache, backups)
│   ├── 📁 logs/             # 📋 Application logs
│   ├── 📁 cache/            # ⚡ Cache files
│   └── 📁 backups/          # 💾 Database backups
├── 📁 tests/                 # 🧪 Unit tests
├── 📁 vendor/                # 📦 Composer dependencies
├── 📄 composer.json          # 📋 PHP dependencies
├── 📄 .htaccess              # 🔒 Root security
├── 📄 README.md              # 📖 Documentation
└── 📄 requirements.txt       # 📋 System requirements
```

## 🔑 User Roles & Permissions

| Role | Permissions | Access Level |
|------|-------------|--------------|
| **👑 Admin** | Full system access, user management, system configuration | Complete |
| **🎓 Patron** | Member management, event creation, attendance marking | High |
| **👤 Member** | View personal data, register for events, view projects | Limited |

## 🗄️ Database Schema

### Core Tables
- `users` - User authentication and roles
- `members` - Club member information
- `events` - Club events and activities
- `event_registrations` - Event participation tracking
- `attendance` - Attendance records
- `projects` - Innovation projects
- `project_members` - Project team assignments

### Relationships
- Users ↔ Members (One-to-One)
- Events ↔ Event Registrations (One-to-Many)
- Members ↔ Attendance (Many-to-One)
- Projects ↔ Project Members (One-to-Many)

## 🎨 Technologies Used

### Backend
- **PHP 7.4+**: Server-side scripting
- **MySQL 5.7+**: Database management
- **PDO**: Database abstraction layer

### Frontend
- **HTML5**: Semantic markup
- **CSS3**: Responsive styling with Flexbox/Grid
- **JavaScript (ES6+)**: Client-side interactivity
- **Font Awesome**: Icon library

### Architecture
- **MVC Pattern**: Model-View-Controller architecture
- **PSR-4 Autoloading**: Standard PHP autoloading
- **Composer**: Dependency management

### Security
- **CSRF Protection**: Cross-site request forgery prevention
- **Input Validation**: Server-side validation
- **SQL Injection Prevention**: Prepared statements
- **XSS Protection**: Output escaping
- **Session Security**: Secure session management

## 🚀 Usage Guide

### First Time Setup
1. Access the application URL
2. Login with default admin credentials
3. Change default password immediately
4. Configure system settings
5. Add initial members and events

### Daily Operations
1. **Member Management**: Add/edit member information
2. **Event Planning**: Create events and manage registrations
3. **Attendance**: Mark attendance for events
4. **Project Tracking**: Monitor project progress
5. **Reporting**: Generate reports as needed

### Maintenance
- Regular database backups
- Monitor application logs
- Update dependencies periodically
- Review user permissions

## 🔧 Configuration

### Environment Variables
Create a `.env` file in the root directory:
```env
APP_NAME="Innovation Club Management"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost/innovation_club

DB_HOST=localhost
DB_NAME=innovation_club_db
DB_USER=root
DB_PASS=your_password

MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USER=your_email@gmail.com
MAIL_PASS=your_app_password
```

### Database Configuration
Update `app/config/database.php` with your database credentials.

### Email Configuration
Configure SMTP settings for email notifications in `app/config/mail.php`.

## 🧪 Testing

### Running Tests
```bash
# Install test dependencies
composer install --dev

# Run all tests
./vendor/bin/phpunit

# Run specific test suite
./vendor/bin/phpunit tests/MemberTest.php
```

### Code Quality
```bash
# Check code style
./vendor/bin/phpcs --standard=PSR12 app/

# Fix code style issues
./vendor/bin/phpcbf --standard=PSR12 app/

# Run static analysis
./vendor/bin/phpmd app/ text codesize,unusedcode,naming
```

## 🚀 Deployment

### Production Checklist
- [ ] Disable debug mode
- [ ] Configure production database
- [ ] Set proper file permissions
- [ ] Enable HTTPS/SSL
- [ ] Configure backup system
- [ ] Set up monitoring
- [ ] Update security headers

### Server Configuration
```apache
# Apache Virtual Host Example
<VirtualHost *:80>
    ServerName innovation-club.local
    DocumentRoot /var/www/innovation-club/public

    <Directory /var/www/innovation-club/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/innovation-club_error.log
    CustomLog ${APACHE_LOG_DIR}/innovation-club_access.log combined
</VirtualHost>
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write comprehensive tests
- Update documentation
- Ensure security best practices

## 📊 API Documentation

### RESTful Endpoints
- `GET /api/members` - List members
- `POST /api/members` - Create member
- `GET /api/events` - List events
- `POST /api/events` - Create event
- `GET /api/attendance` - Get attendance data

### Authentication
All API endpoints require Bearer token authentication.

## 🐛 Troubleshooting

### Common Issues
1. **404 Errors**: Check URL rewriting configuration
2. **Database Connection**: Verify database credentials
3. **Permission Errors**: Set proper file permissions
4. **Session Issues**: Check session save path

### Debug Mode
Enable debug mode in `app/config/app.php` for detailed error messages.

## 📝 Changelog

### Version 1.0.0 (Current)
- Initial release with core functionality
- MVC architecture implementation
- Role-based access control
- Responsive UI design
- Database schema with relationships
- Security enhancements

## 📄 License

This project is developed for educational purposes as part of the Diploma in ICT Trade Project at Elite Academy. All rights reserved.

## 👥 Support

For support and questions:
- **Email**: support@eliteacademy.edu
- **Documentation**: [Project Wiki](https://github.com/elite-academy/innovation-club/wiki)
- **Issues**: [GitHub Issues](https://github.com/elite-academy/innovation-club/issues)

## 🙏 Acknowledgments

- Developed by Diploma in ICT students at Elite Academy
- Special thanks to faculty and mentors
- Built with modern web technologies and best practices

---

**Elite Academy Innovation Club Management System** © 2024. Crafted with ❤️ for innovation and excellence.