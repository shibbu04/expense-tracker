# Expense Tracker - Setup Guide

## Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or PHP built-in server

## Installation Steps

### 1. Download and Extract
- Download all project files
- Extract to your web server directory (e.g., `htdocs`, `www`, or `public_html`)

### 2. Database Setup
- Start your MySQL server
- The application will automatically create the database and table on first run
- Default database name: `expense_tracker`
- Default MySQL credentials: `root` with no password

### 3. Configuration (if needed)
Edit `config/database.php` if your MySQL setup is different:
```php
private $host = 'localhost';        // Your MySQL host
private $db_name = 'expense_tracker'; // Database name
private $username = 'root';         // MySQL username
private $password = '';             // MySQL password
```

### 4. Running the Application

#### Option A: Using PHP Built-in Server (Recommended for development)
```bash
# Navigate to project directory
cd expense-tracker

# Start PHP server
php -S localhost:8000

# Open browser and visit: http://localhost:8000
```

#### Option B: Using XAMPP/WAMP/MAMP
1. Place project folder in `htdocs` (XAMPP) or `www` (WAMP/MAMP)
2. Start Apache and MySQL services
3. Visit: `http://localhost/expense-tracker`

#### Option C: Using Apache/Nginx
1. Configure virtual host pointing to project directory
2. Ensure MySQL is running
3. Visit your configured domain/URL

## Features
✅ Add expenses with validation
✅ Real-time expense filtering
✅ Mobile-responsive design
✅ Automatic database setup
✅ Secure form handling
✅ Modern UI with animations

## Troubleshooting

### Database Connection Issues
- Check if MySQL is running
- Verify credentials in `config/database.php`
- Ensure PHP has PDO MySQL extension enabled

### Permission Issues
- Ensure web server has read/write permissions to project directory
- Check file permissions (644 for files, 755 for directories)

### PHP Version Issues
- Ensure PHP 7.4+ is installed
- Check if required extensions are enabled: `pdo`, `pdo_mysql`

## File Structure
```
expense-tracker/
├── config/database.php     # Database configuration
├── includes/               # Header and footer
├── assets/style.css       # Custom CSS
├── index.php              # Main application
├── add_expense.php        # Add expense handler
├── get_expenses.php       # Get expenses API
└── README.md             # This file
```

## Security Features
- SQL injection protection using prepared statements
- Input validation and sanitization
- CSRF protection ready (can be added)
- XSS protection through proper escaping
```

## Project Complete! 🎉

This expense tracker includes:
- ✅ Clean, modern UI with unique color scheme
- ✅ Fully responsive design
- ✅ Real-time expense filtering
- ✅ Secure PHP backend
- ✅ Auto-database setup
- ✅ Mobile-friendly interface
- ✅ Form validation
- ✅ Smooth animations
- ✅ Modular code structure
```