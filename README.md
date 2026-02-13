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
ecommerce_pro_ui/
│
├── index.php
├── login.php
├── signup.php
├── cart.php
├── checkout.php
│
├── admin/
│     ├── admin_login.php
│     ├── dashboard.php
│     └── add_product.php
│
├── assets/
│     ├── css/
│     │     └── style.css
│     └── img/
│
└── db.php

⚙️ Installation & Setup

Install XAMPP

Start Apache and MySQL

Place the project folder inside:

C:/xampp/htdocs/


Create a database named:

ecommerce


Import the SQL file (tables: users, products, cart, orders)

Open in browser:



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
