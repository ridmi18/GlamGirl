<p align="center">
  <img src="images/logo.png" alt="GlamGirl Logo" width="500">
</p>

<h1 align="center">GlamGirl - Fashion E-Commerce Website</h1>

<p align="center">
  A fashion e-commerce website developed using PHP, MySQL, HTML, CSS, and JavaScript.
</p>

---

## Overview

GlamGirl is a fashion e-commerce website designed to provide users with a convenient and user-friendly online shopping experience.

The platform allows customers to explore fashion products, manage their shopping carts, and place orders through an interactive web interface. It also includes a virtual fitting feature to enhance the shopping experience.

## Features

- **User Authentication** - User registration and login.
- **Product Browsing** - Explore available fashion products.
- **Shopping Cart** - Add and manage selected products.
- **Checkout** - Place orders through the checkout process.
- **Order Management** - Manage customer orders.
- **Virtual Fitting** - Dedicated virtual fitting functionality.
- **Customer Feedback** - Customer feedback and contact functionality.
- **Responsive Design** - User-friendly interface across different screen sizes.

## Technologies Used

| Technology | Purpose |
|---|---|
| PHP | Server-side development |
| MySQL | Database management |
| HTML5 | Website structure |
| CSS3 | Styling and layout |
| JavaScript | Interactive functionality |
| Bootstrap | Responsive UI components |

## Installation and Setup

### Prerequisites

- XAMPP (Apache and MySQL)
- PHP-compatible web browser
- Code editor (optional)

### Getting Started

**1. Clone the repository**

```bash
git clone https://github.com/ridmi18/GlamGirl.git
```

**2. Move the project to XAMPP**

Place the cloned `GlamGirl` folder inside the XAMPP `htdocs` directory.

```text
C:\xampp\htdocs\GlamGirl
```

**3. Configure the database**

- Start Apache and MySQL from the XAMPP Control Panel.
- Open phpMyAdmin at `http://localhost/phpmyadmin`.
- Create the required MySQL database.
- Import the database schema if available.
- Configure the connection settings in `classes/DatabaseConnector.php`.

**4. Run the application**

Open your browser and navigate to:

```text
http://localhost/GlamGirl/
```

## Project Structure

```text
GlamGirl/
├── classes/
│   └── DatabaseConnector.php
├── images/
│   └── logo.png
├── index.php
├── signup.php
├── virtual-fitting.php
└── README.md
```

*The structure above highlights the main project files and directories.*

## Screenshots

Application screenshots can be added to demonstrate the user interface and functionality.

Suggested screenshots:

- Home Page
- Product Listings
- Shopping Cart
- Checkout Page
- Virtual Fitting Page

## Related Repository

**GlamGirl - Admin Management System**

A Java Swing desktop application developed to manage products, inventory, users, orders, and customer feedback for the GlamGirl platform.

[View GlamGirl Admin Management System](https://github.com/ridmi18/GlamGirl-Admin-System)

## Author

**Ridmi Hesara**

GitHub: [@ridmi18](https://github.com/ridmi18)

---

<p align="center">
  Developed as an academic software development project.
</p>