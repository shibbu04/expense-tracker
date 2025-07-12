# 💸 Expense Tracker App – PHP + MySQL

A simple and elegant web application to **track your daily expenses**. Built using **PHP and MySQL**, this app helps users **add, view, filter, and summarize** their expenses with ease.

---

## 🎯 Objective

To build a PHP-MySQL powered application that allows users to:

* Add and manage their daily expenses
* Filter expenses by month and year
* Calculate total expenditure over selected periods

---

## 🛠 Skills Practiced

* PHP CRUD operations
* MySQL database integration
* Form handling & session basics
* Data filtering and aggregation
* Modular and secure backend logic

---

## ✅ Core Features

### 1. Add Expense

📝 Users can record new expenses by submitting:

* Date of expense
* Amount spent
* Category (e.g., Food, Transport, Utilities)
* Description (optional)

### 2. View All Expenses

📋 Displays all expense entries in a **tabular format** with:

* Date
* Category
* Amount
* Description

### 3. Filter by Month & Year

📆 Users can filter expenses by:

* **Month** (e.g., January, February, etc.)
* **Year**
  💡 This helps users analyze their spending behavior.

### 4. Total Expense Summary

💰 Calculates the **total spending** for the selected time period and displays it clearly.

---

## 🚀 Additional Features

* 🔄 Automatic table creation on first load
* 🧮 Inline total calculation
* 💡 Debug mode for testing database connectivity
* 🧪 API endpoints for Add/Get/Delete
* 📱 Responsive UI for mobile and desktop
* 🔐 Secure form handling using **prepared statements**

---

## 📦 Download & Run (Localhost)

### ✅ Prerequisites

* PHP 7.4 or higher
* MySQL 5.7+
* Apache/Nginx or PHP built-in server

---

## 🧩 Setup Guide

### 1. Download Project

```bash
git clone https://github.com/shibbu04/expense_tracker.git
```

> Or manually download and extract into your web root (`htdocs`, `www`, etc.)

---

### 2. Database Configuration

Default MySQL setup:

```php
private $host = 'localhost';
private $db_name = 'expense_tracker';
private $username = 'root';
private $password = '';
```

⚙ Edit `config/database.php` to match your MySQL credentials.

---

### 3. Run the App

#### 🔹 Option A: PHP Built-in Server

```bash
cd expense-tracker
php -S localhost:8000
```

Open in browser: `http://localhost:8000`

---

#### 🔹 Option B: XAMPP/WAMP/MAMP

1. Place project in `htdocs` or `www`
2. Start Apache and MySQL
3. Visit: `http://localhost/expense-tracker`

---

## 🔍 File Structure

```
expense-tracker/
├── config/              # DB config
├── includes/            # Shared header/footer
├── assets/              # CSS, images
├── index.php            # Dashboard
├── add_expense.php      # Add handler
├── get_expenses.php     # Fetch API
├── delete_expense.php   # Delete API
├── debug.php            # Debug utility
└── README.md
```

---

## 🧠 Troubleshooting

### ❌ Can’t Connect to DB?

* Check MySQL is running
* Ensure DB credentials are correct in `config/database.php`
* Verify `pdo` and `pdo_mysql` extensions are enabled in PHP

### ❌ Page not loading?
 * Check PHP version (must be 7.4+)
 * Look for errors in browser/console/debug.php
---

## 🔐 Security Practices

* ✅ Prepared statements to prevent SQL Injection
* ✅ HTML escaping to prevent XSS
* ✅ Basic input validation
* 🔄 CSRF ready structure (can be extended)

---

## ✅ Project Completed!

### Final Highlights:

* ✔ Simple & modern UI
* ✔ Clean code with modular structure
* ✔ Real-time filter & total updates
* ✔ Secure backend
* ✔ Automatic DB setup
* ✔ Designed for learning and improvement

---

### 🔗 Connect With Me
 * 🌐 Portfolio: https://shivam04.tech

 * 💼 GitHub: https://github.com/shibbu04

 * 🔗 LinkedIn: https://linkedin.com/in/shivamsingh57680
