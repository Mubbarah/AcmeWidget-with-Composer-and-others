# Acme Widget Co - Basket System

## Overview

This is a PHP-based basket management system for **Acme Widget Co.** It allows users to:
- Add products to a basket.
- View a breakdown of:
  - Subtotal
  - Delivery charges
  - Grand total.
- Clear the basket.

The system is designed with modular, testable code and integrates tools like PHPUnit for unit testing and Composer for dependency management.

---

## Features

1. **Dynamic Product Management:**
   - Products are managed via a `ProductCatalogue` class, allowing for easy addition and retrieval.

2. **Delivery Cost Calculation:**
   - Delivery charges are calculated dynamically based on thresholds:
     - Orders below $50: $4.95
     - Orders below $90: $2.95
     - Orders $90 and above: Free delivery.

3. **Basket System:**
   - Handles product additions, subtotal calculations, delivery charges, and total cost.

4. **Unit Testing with PHPUnit:**
   - Includes test cases for core functionalities, such as calculating the subtotal and delivery charges.

5. **Clear Basket Functionality:**
   - Users can reset the basket to start fresh.

---

## Technologies Used

1. **PHP 8.0+:** For the core functionality.
2. **Composer:** For autoloading and dependency management.
3. **PHPUnit:** For unit testing.
4. **Bootstrap:** For styling the front-end interface.
5. **XAMPP:** For local development.

---

## Installation and Setup

### 1. Clone the Repository
```bash
git clone https://github.com/Mubbarah/AcmeWidget-with-Composer-and-others.git
cd AcmeWidget
"# AcmeWidget-with-Composer-and-others" 
