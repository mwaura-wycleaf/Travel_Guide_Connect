

# TRAVEL GUIDE CONNECT – SYSTEM MANUAL

**A Multi-Tier Web Application for Tourist-Guide Connectivity**

## 📌 Project Overview

**Travel Guide Connect** is a full-stack web application designed to bridge the gap between international/local travelers and professional local guides. The platform features a unique seasonal filtering mechanism, allowing users to discover Kenyan attractions based on weather patterns (Dry Season, Long Rains, Short Rains) and book expert guides for personalized tours.

This project was developed as a collaborative effort for the **Computer Science** curriculum at **Dedan Kimathi University of Technology (DeKUT)**.

-----

## 🚀 Key Modules & Features

### 👤 Traveler (User) Interface

  * **Seasonal Discovery:** Filter attractions by their best visiting times based on weather suitability.
  * **Guide Directory:** Browse professional guides based on expertise (Hiking, Wildlife, Cultural Tours).
  * **Booking System:** Send real-time reservation requests to specific guides.
  * **Review System:** Submit feedback and ratings for guides after completion of tours.

### 🧭 Guide Portal

  * **Profile Management:** Update professional bios, experience years, and specialization areas.
  * **Booking Oversight:** View and process traveler requests.
  * **Performance Tracking:** Monitor traveler ratings and reviews for quality improvement.

### 🛠 Admin Panel

  * **System Metrics:** Real-time dashboard showing total guides, destinations, and active inquiries.
  * **Content Management (CRUD):** Full control over destination listings and guide registrations.
  * **Inquiry Handling:** View and manage contact messages from the public.

-----

## 💻 Tech Stack

  * **Backend:** PHP 8.x
  * **Database:** MySQL (Relational)
  * **Frontend:** HTML5, CSS3, JavaScript (Poppins Typography, FontAwesome 6.4.0)
  * **Environment:** XAMPP / Apache Server

-----

## 📁 System Architecture (File Tree)

```text
TRAVEL_GUIDE_CONNECT/
├── admin/                    # Administrative Control Panel
│   ├── Includes/             # Admin-specific logic
│   │   ├── admin_auth.php    # Session security gatekeeper
│   │   └── admin_logout.php  # Admin session termination
│   ├── dashboard.php         # Admin metrics overview
│   ├── manage_attractions.php# Destination CRUD operations
│   ├── manage_bookings.php   # Reservation oversight
│   ├── manage_guides.php     # Guide registration & management
│   ├── manage_reviews.php    # Feedback moderation
│   ├── manage_users.php      # Traveler account management
│   └── view_messages.php     # Contact inquiry inbox
├── assets/                   # Static Frontend Assets
│   ├── css/                  # Stylesheets (Layout, Typography)
│   └── js/                   # Client-side interactivity
├── auth/                     # Authentication Module
│   ├── login.php             # Secure login portal
│   ├── logout.php            # Global logout script
│   ├── register.php          # Traveler signup
│   └── signup.php            # Registration logic
├── database/                 # Data Persistence
│   └── travel_guide.sql      # Database schema & sample data
├── guide/                    # Local Guide Interface
│   ├── includes/             # Guide-specific fragments
│   ├── availability.php      # Schedule management
│   ├── dashboard.php         # Guide personal metrics
│   ├── edit_profile.php      # Bio and specialization updates
│   ├── manage_bookings.php   # Personal booking requests
│   ├── manage_reviews.php    # Personal feedback view
│   └── process_booking.php   # Booking acceptance logic
├── images/                   # Upload Directory (Attractions & Profiles)
├── includes/                 # Global Shared Components
│   ├── db.php                # MySQLi Connection configuration
│   ├── footer.php            # Global page footer
│   ├── header.php            # Global navigation & logo
│   └── sidebar.php           # Navigation menu logic
├── processes/                # Functional Backend Logic
│   └── send_message.php      # Contact form processing
├── about.php                 # Platform information
├── attraction_details.php    # Individual destination view
├── attractions.php           # Destination listing & filters
├── book.php                  # Booking request interface
├── contact.php               # Traveler contact form
├── fetch_attractions.php     # AJAX-ready data fetching
├── guide_profile.php         # Public guide profile view
├── guides_list.php           # Directory of local guides
├── index.php                 # Application Landing Page
├── my_bookings.php           # Traveler's reservation history
├── post_review.php           # Review submission logic
└── view_map.php              # Geographic visualization
```

-----

## 💿 Installation & Deployment Guide

### 1\. Environment Setup

  * **Install XAMPP:** Ensure you have XAMPP installed (PHP 8.0+ recommended).
  * **Service Activation:** Open the XAMPP Control Panel and start **Apache** and **MySQL**.
  * **Port Check:** Ensure MySQL is running on port **3306**. If using **3307**, update the connection string in `includes/db.php`.

### 2\. File Deployment (CD or GitHub)

  * **Option A (CD):** Copy the `Travel_Guide_Connect` folder from this CD to `C:\xampp\htdocs\`.
  * **Option B (Cloning):** Alternatively, clone the repository directly into your htdocs:
    ```bash
    git clone https://github.com/mwaura-wycleaf/Travel_Guide_Connect.git
    ```

### 3\. Database Initialization

  * **Access phpMyAdmin:** Open your browser to `http://localhost/phpmyadmin/`.
  * **Create Database:** Create a new database exactly named `travel_guide_connect`.
  * **Import Schema:** Select `travel_guide_connect`, click the **Import** tab, and browse to the SQL file:
    `C:\xampp\htdocs\Travel_Guide_Connect/database/travel_guide.sql`.
  * **Execution:** Click **Go**. All tables should populate successfully.

### 4\. Accessing the System

  * Navigate to: `http://localhost/Travel_Guide_Connect/`

-----

## 🔑 Access Credentials (Demo)

| Role | Username / Email | Password |
| :--- | :--- | :--- |
| **Administrator** | admin@tconnect.co.ke | password |
| **Professional Guide** | fatuma.k@example.com | 123456 |
| **Traveler** | eunice@gmail.com | 123456 |

-----

### **Live Project**
**URL:** http://travelguideconnect.free.nf/
*This live demonstration is hosted on a production-grade LAMP environment, showcasing the application's stability, relational database performance, and mobile-responsive UI outside of the initial development environment.*
### **Quick Deployment Note**
> **Note:** Due to the free hosting tier, if the site fails to load, it may be undergoing brief server maintenance or have exceeded daily resource limits. For a persistent preview, refer to the local installation instructions below.
>

### 👨‍💻 Project Development Team

**Institution:** Dedan Kimathi University of Technology (DeKUT)  
**Course:** Bachelor of Science in Computer Science

  * **[mwaura-wycleaf](https://github.com/mwaura-wycleaf) (Lead Developer):**
      * Developed the full-stack logic for the **Traveler/User** module.
      * Designed the **Database Architecture** and Relational Schema.
  * **[TracyNdiritu](https://github.com/TracyNdiritu):**
      * Developed the **Administrative Panel** and system oversight features.
      * Implemented management systems for attractions, bookings, and user metrics.
  * **[christon-mwash](https://github.com/christon-mwash):**
      * Developed the **Professional Guide** Interface.
      * Implemented guide profile management, booking processing, and availability logic.
