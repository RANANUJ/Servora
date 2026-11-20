# Servora — Local Service Marketplace

<p align="center">
  <strong>Discover trusted professionals. Book services. Get things done.</strong>
</p>

<p align="center">
  A web-based local service marketplace that connects customers with service providers through a simple, convenient, and user-friendly platform.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
</p>

---

## About Servora

**Servora** is a local service marketplace designed to make finding and booking professional services easier.

Customers can explore available services, discover service providers, book appointments, manage their bookings, and share feedback after completing a service.

Service providers can create business profiles, publish their services, manage customer bookings, and build their reputation through customer reviews.

The platform also includes an administration panel for managing and monitoring marketplace activities.

Servora aims to create a reliable connection between people who need services and professionals who provide them.

## Key Features

### Customer Panel

- Customer registration and secure login.
- Browse service categories and available services.
- Explore service details and provider information.
- Book services with appointment details.
- View and manage personal bookings.
- Track booking status.
- Submit ratings and written reviews after completed bookings.
- View previously submitted reviews.
- Manage customer profile information.
- Become a service provider using the existing customer account.

### Service Provider Panel

- Create a business profile.
- Manage business information.
- Add services with descriptions, pricing, and images.
- Browse and manage published service listings.
- Receive customer booking requests.
- View complete booking details.
- Accept or reject booking requests.
- Update bookings as work progresses.
- Mark bookings as completed.
- View customer reviews and average ratings.

### Admin Panel

The administration panel is intended to provide centralized marketplace management.

Planned management areas include:

- Customer and provider account management.
- Service category management.
- Service listing management.
- Booking monitoring.
- Review moderation.
- Contact message management.
- Marketplace activity overview.

*Note: Features identified as planned should be considered future development until implemented.*

## Technology Stack

| Technology | Purpose |
|---|---|
| HTML5 | Application structure |
| CSS3 | Custom styling and responsive layouts |
| Bootstrap 5 | Responsive UI components |
| JavaScript | Frontend interactions |
| PHP 8+ | Backend application logic |
| MySQL | Relational database |
| PDO | Secure database communication |
| Apache | Local web server |
| XAMPP | Local development environment |
| Git & GitHub | Version control and source management |

## Application Architecture

Servora follows a **Model-View-Controller (MVC)** architecture to keep the application organized and maintainable.

```text
User Request
     |
     v
   Router
     |
     v
 Controller
     |
     v
   Model
     |
     v
  Database
     |
     v
 Controller
     |
     v
    View
     |
     v
  User Interface
```

### MVC Responsibilities

- **Models:** Handle database operations and application data.
- **Views:** Display application pages and user interfaces.
- **Controllers:** Process requests, validate input, enforce application rules, and coordinate models and views.
- **Core:** Contains shared application functionality such as routing, controllers, sessions, and CSRF protection.

## Project Structure

```text
servora/
│
├── app/
│   ├── config/
│   │   ├── app.php
│   │   └── database.php
│   │
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── BookingController.php
│   │   ├── DashboardController.php
│   │   ├── ProviderController.php
│   │   └── ServiceController.php
│   │
│   ├── core/
│   │   ├── bootstrap.php
│   │   ├── Controller.php
│   │   ├── Csrf.php
│   │   └── Router.php
│   │
│   ├── middleware/
│   │
│   ├── models/
│   │   ├── Booking.php
│   │   ├── Category.php
│   │   ├── Model.php
│   │   ├── Provider.php
│   │   ├── Review.php
│   │   ├── Service.php
│   │   └── User.php
│   │
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── dashboard/
│       ├── home/
│       ├── layouts/
│       ├── provider/
│       └── services/
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   │
│   ├── uploads/
│   ├── .htaccess
│   └── index.php
│
├── routes/
│   └── web.php
│
└── README.md
```

*The structure above represents the main application organization. Additional files and folders may exist in the working repository.*

## Database Overview

Servora uses MySQL for storing application data.

The main database tables include:

| Table | Responsibility |
|---|---|
| `users` | Customer, provider, and admin accounts |
| `provider_profiles` | Business and provider information |
| `categories` | Main service categories and subcategories |
| `services` | Provider service listings |
| `bookings` | Customer service bookings |
| `reviews` | Customer ratings and feedback |
| `contact_messages` | Website contact enquiries |
| `notifications` | User notifications |

### Important Relationships

- A user can have a linked provider profile.
- A provider profile can publish multiple services.
- Services belong to categories.
- Customers can create multiple bookings.
- Providers receive bookings for their services.
- Completed bookings can receive customer reviews.
- Notifications are associated with individual users.

## Installation and Setup

Follow these steps to run Servora locally.

### Prerequisites

Install the following:

- [XAMPP](https://www.apachefriends.org/)
- PHP 8 or later
- MySQL
- [Visual Studio Code](https://code.visualstudio.com/)
- [Git](https://git-scm.com/)

### 1. Clone the repository

Open your terminal and run:

```bash
git clone https://github.com/RANANUJ/Servora.git
```

### 2. Move the project into XAMPP

Place the cloned project inside:

```text
C:\xampp\htdocs\servora
```

### 3. Start XAMPP

Open the XAMPP Control Panel and start:

- Apache
- MySQL

### 4. Create the database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Create a database named:

```text
servora_db
```

Import the project's SQL schema or database backup if one is included in the repository.

If no SQL file is included, create the required tables using the project's database schema.

### 5. Configure the database connection

Open:

```text
app/config/database.php
```

Configure your local MySQL connection.

Typical XAMPP development settings:

```php
Host: localhost
Username: root
Password: (blank by default)
Database: servora_db
```

Use the actual connection format already defined in the project.

### 6. Configure the application URL

Open:

```text
app/config/app.php
```

For the local XAMPP setup, the application URL should be:

```php
define('APP_URL', 'http://localhost/servora/public');
```

### 7. Open Servora

Visit:

**http://localhost/servora/public**

The application should now be accessible locally.

## Application Workflows

### Customer Workflow

```text
Visit Servora
     |
     v
Register / Login
     |
     v
Browse Services
     |
     v
View Service Details
     |
     v
Book a Service
     |
     v
Track Booking
     |
     v
Service Completed
     |
     v
Submit Rating & Review
```

### Service Provider Workflow

```text
Customer Account
     |
     v
Become a Service Provider
     |
     v
Create Business Profile
     |
     v
Access Provider Dashboard
     |
     v
Publish Services
     |
     v
Receive Bookings
     |
     v
Manage Booking Status
     |
     v
Complete Service
     |
     v
Receive Customer Reviews
```

## Security and Development Practices

Servora is developed with attention to backend security and maintainability.

Security measures include:

- PDO prepared statements for database queries.
- Password hashing for account passwords.
- Session-based authentication.
- Session ID regeneration after successful login.
- CSRF token validation for protected form submissions.
- Server-side input validation.
- Role-based access restrictions.
- Provider ownership checks for booking operations.
- File upload validation using MIME type and image checks.
- Output escaping to reduce cross-site scripting risks.
- Database relationships and constraints to maintain data integrity.

## User Interface and Design

Servora follows a consistent visual identity across its application panels.

The design direction includes:

- Deep navy for strong visual hierarchy.
- Bright blue for primary actions.
- Warm orange for highlights.
- Soft off-white backgrounds.
- Clean typography using DM Sans.
- Rounded cards and subtle shadows.
- Responsive layouts for different screen sizes.
- Consistent navigation, buttons, forms, and dashboard components.

The goal is to provide a polished experience that feels simple, trustworthy, and professional.

## Future Enhancements

Potential improvements for future releases include:

- Online payment gateway integration.
- Provider earnings and transaction tracking.
- Advanced search and location-based filtering.
- Real-time notifications.
- Booking reminders.
- Provider analytics and performance reports.
- Advanced review moderation.
- Customer and provider support features.
- Automated email notifications.
- Production deployment and performance optimization.

## Contributing

Contributions and suggestions are welcome.

If you would like to contribute:

1. Fork the repository.
2. Create a feature branch.
3. Make your changes.
4. Test your changes locally.
5. Submit a pull request.

## Project Repository

**GitHub:**  
https://github.com/RANANUJ/Servora

## License

No license has been specified yet. All rights are reserved by the repository owner unless a license is added to the project.

---

<p align="center">
  <strong>Servora — Your Local Services, Simplified.</strong>
  <br>
  Connecting customers with trusted local professionals.
</p>