🛒 Cartify – E-Commerce Website

🚀 A full-stack web-based e-commerce platform built using PHP and MySQL.

📌 Project Overview

Cartify is a dynamic e-commerce website that allows users to browse products by category, add items to cart, and place orders.
It also includes an admin panel for product management.

This project was developed as part of the MCA academic curriculum to understand real-world full-stack web development.

🧰 Tech Stack

Frontend

HTML5

CSS3

Backend

PHP

Database

MySQL

Server

XAMPP (Apache + MySQL)

✨ Features
👤 User Features

    User Registration & Login (Session-based authentication)

    Browse Products by Categories

    Product Detail View

    Add to Cart

    Cart Total Calculation

    Order Placement (Checkout)

    Logout Functionality

🛠️ Admin Features

    Secure Admin Login

    Add New Products

    Upload Product Images

    Manage Product Listings

🗂️ Database Structure

The project uses four main tables:

users – Stores user details

products – Stores product information

cart – Stores user cart items

orders – Stores placed orders

🔄 System Workflow

User → Browse Products → Add to Cart → Checkout → Order Stored in Database

Admin → Login → Add/Manage Products → Products Visible to Users

📁 Project Structure
## 📁 Project Structure

```bash
Cartify-Ecommerce-Website/
│
├── index.php              # Homepage – Displays products
├── login.php              # User login page
├── signup.php             # User registration page
├── logout.php             # Logout functionality
├── product_detail.php     # Product details page
├── add_to_cart.php        # Add product to cart logic
├── cart.php               # User shopping cart
├── checkout.php           # Order placement logic
├── db.php                 # Database connection file
│
├── admin/
│   ├── admin_login.php    # Admin authentication
│   ├── dashboard.php      # Admin dashboard
│   └── add_product.php    # Add new product
│
├── assets/
│   ├── css/
│   │   └── style.css      # Main stylesheet
│   ├── img/               # Product images
│   └── js/                # Future JS files
│
├── database/
│   └── ecommerce.sql      # SQL database file
│
└── README.md              # Project documentation
```


⚙️ Installation & Setup

Install XAMPP

Start Apache and MySQL

Place the project folder inside:

C:/xampp/htdocs/



🗄️ Database Setup Using XAMPP

Follow these steps to set up the database:

1️⃣ Install XAMPP

Download and install XAMPP.

2️⃣ Start Apache & MySQL

Open XAMPP Control Panel and start:

Apache

MySQL

3️⃣ Open phpMyAdmin

Go to:

http://localhost/phpmyadmin/

4️⃣ Create Database

Click New

Enter database name:

ecommerce


Click Create

5️⃣ Import SQL File

Select the ecommerce database

Click Import

Click Choose File

Select:

database/ecommerce.sql


Click Go

Tables will be created automatically.

✅ Alternative: Manual SQL Execution

You can also:

Go to phpMyAdmin

Click on ecommerce database

Open SQL tab

Copy content from:

database/ecommerce.sql


💡 Extra Professional Touch

Add this above it:


🔐 Security Notes

Session-based authentication implemented

Basic login validation

Future improvement: prepared statements & password hashing

🚀 Future Enhancements

Payment Gateway Integration

Order History Page

Product Search & Filter

Role-Based Access Control

Improved Security (SQL Injection prevention)


📚 What I Learned

Full-stack PHP–MySQL integration

Session management

Database design & relationships

CRUD operations

Admin panel implementation

👨‍💻 Author

Mohd Sarim Khan
