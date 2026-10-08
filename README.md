
# Smart Building Monitoring Platform

A web-based smart building monitoring platform developed as a personal academic and portfolio project.

The main goal of this project is to build a practical and easy-to-understand system for monitoring building devices, energy consumption, temperature data, and system alerts through a centralized dashboard.

The project was developed to gain practical experience in backend development, relational database design, authentication, API development, file handling, and frontend-backend integration using PHP and MySQL.

---

## Project Overview

Smart Building Monitoring Platform provides a centralized web interface for monitoring and managing information related to a smart building.

The platform brings several types of building information together in one place, including:

- Device status
- Energy consumption
- Power demand
- Temperature data
- Building alerts
- Building information
- User profile information
- Building settings

The project focuses on building a clear and understandable web application using fundamental web technologies rather than relying on unnecessary frameworks or over-engineered architecture.

The system was developed as a learning-focused project to understand how a frontend, backend, database, authentication system, and APIs work together as one web application.

---

## Main Features

### Dashboard

The dashboard provides an overview of the building and its current monitoring information.

Features include:

- Total device statistics
- Online, warning, and offline device counts
- Energy consumption information
- Power demand information
- Temperature monitoring
- Recent system alerts
- Building overview
- Dashboard search functionality
- User profile information

The dashboard receives monitoring information from the backend and displays the data through cards, charts, and alert components.

---

### Device Management

The device management section allows users to work with registered building devices.

Features include:

- View registered devices
- Add new devices
- Update device information
- Delete devices
- Track device status
- Store device type
- Store device location
- Store the latest device update time

Device operations are handled through the PHP backend and stored in the MySQL database.

---

### Energy Monitoring

The energy section is used to store and display building energy information.

Features include:

- Energy consumption data
- Power demand data
- Recorded timestamps
- Database-based energy records
- Frontend visualization of energy information

Energy records are stored in the `energy_data` table and retrieved through the backend API.

---

### Temperature Monitoring

The temperature monitoring functionality stores and displays temperature measurements.

Features include:

- Temperature records
- Recorded timestamps
- Building association
- Device association
- Database-based temperature history
- Frontend visualization

Temperature records are stored in the `temperature_data` table.

---

### Alert Management

The alert section provides information about building and device alerts.

Supported information includes:

- Alert type
- Alert title
- Alert description
- Alert creation time
- Building association
- Device association
- Alert resolution status

The system supports alert categories such as:

- Critical
- Warning
- Information

Unresolved alerts can be retrieved by the dashboard and displayed to the user.

---

### User Authentication

The application includes a basic session-based authentication system.

Features include:

- User registration
- User login
- Session-based authentication
- Logout functionality
- Password hashing
- Password verification
- Protected pages
- Protected API endpoints

Passwords are hashed using PHP's built-in password hashing functionality.

During login, the submitted password is checked using `password_verify()`.

---

### User Profile

Users can manage their personal profile information from the profile page.

Features include:

- View profile information
- Edit full name
- Edit email address
- Change password
- Add phone number
- Add home address
- Upload a profile picture
- Display the profile image across the platform
- Display the first letter of the user's name when no profile image is available

Profile information is stored in the `users` table.

Profile images are stored separately inside the `uploads/profile/` directory, while their relative paths are stored in the database.

---

### Building Settings

The settings section allows building information to be updated.

Current building settings include:

- Building name
- Building location
- Building timezone

These values are stored in the `buildings` table.

---

## Frontend

The frontend was developed using:

- HTML5
- CSS3
- JavaScript
- Chart.js
- Lucide Icons

The interface includes separate pages for the main parts of the application:

- Dashboard
- Devices
- Energy
- Alerts
- Settings
- Profile
- Login
- Sign up

The frontend communicates with the PHP backend through API endpoints and uses the returned data to update the interface.

### Interface Features

The application includes:

- Fixed sidebar navigation
- Top navigation area
- User profile information
- Profile avatars
- Building imagery
- Monitoring cards
- Data charts
- Alert components
- Device management interface
- Search functionality
- Responsive layout considerations
- Consistent visual styling across pages

Chart.js is used where graphical visualization helps present monitoring data more clearly.

Lucide Icons are used for interface icons.

---

## Backend

The backend is implemented using PHP.

PHP is responsible for:

- Processing user requests
- Handling authentication
- Managing sessions
- Communicating with MySQL
- Processing forms
- Validating user input
- Handling profile image uploads
- Returning JSON API responses
- Performing CRUD operations for devices
- Retrieving monitoring data
- Updating building information
- Updating user profile information

The backend uses MySQLi for communication with the MySQL database.

The project intentionally uses a simple PHP structure instead of a large framework so that the main backend concepts remain easy to understand.

---

## API

The application uses separate PHP API endpoints for different parts of the system.

Main API endpoints include:

- `api/dashboard.php`
- `api/devices.php`
- `api/energy.php`
- `api/temperature.php`
- `api/alerts.php`
- `api/profile.php`
- `api/settings.php`

The APIs communicate with the frontend using JSON responses.

### Dashboard API

`api/dashboard.php`

Provides dashboard information such as:

- Total devices
- Online devices
- Warning devices
- Offline devices
- Latest energy consumption
- Latest power demand
- Total unresolved alerts
- Critical alerts
- Warning alerts
- Information alerts

---

### Devices API

`api/devices.php`

Handles device-related operations including:

- Retrieve all devices
- Retrieve a specific device
- Add a device
- Update a device
- Delete a device

The API uses prepared SQL statements for operations involving submitted values.

---

### Energy API

`api/energy.php`

Retrieves stored energy monitoring records from the database.

The API returns:

- Energy consumption
- Power demand
- Recorded timestamp
- Associated building and device information where available

---

### Temperature API

`api/temperature.php`

Retrieves temperature monitoring records from the database.

The API returns temperature values together with their recorded timestamps.

---

### Alerts API

`api/alerts.php`

Retrieves stored building and device alerts.

The returned information includes:

- Alert type
- Title
- Description
- Creation time
- Building ID
- Device ID
- Resolution status

---

### Profile API

`api/profile.php`

Handles user profile operations including:

- Retrieve profile information
- Update name
- Update email
- Update phone number
- Update address
- Change password
- Upload profile image

Profile passwords are hashed before being stored in the database.

Profile image uploads are validated before being saved.

---

### Settings API

`api/settings.php`

Handles building settings.

The API allows the application to:

- Retrieve building information
- Update building name
- Update building location
- Update building timezone

---

## Database

The application uses a relational MySQL database.

Database name:

`smart_building`

The database was designed using separate tables for users, buildings, devices, monitoring data, alerts, and settings.

The database uses primary keys and foreign keys to connect related records.

---

## Database Tables

### users

Stores user account and profile information.

Main fields include:

- `id`
- `building_id`
- `name`
- `email`
- `password`
- `role`
- `phone`
- `address`
- `profile_image`
- `created_at`

The password field stores a password hash rather than a plain-text password.

---

### buildings

Stores information about the monitored building.

Main fields include:

- `id`
- `name`
- `location`
- `timezone`
- `created_at`

---

### devices

Stores information about devices installed in the building.

Main fields include:

- `id`
- `building_id`
- `name`
- `type`
- `location`
- `status`
- `last_update`
- `created_at`

---

### energy_data

Stores energy monitoring records.

Main fields include:

- `id`
- `building_id`
- `device_id`
- `energy_consumption`
- `power_demand`
- `recorded_at`

---

### temperature_data

Stores temperature monitoring records.

Main fields include:

- `id`
- `building_id`
- `device_id`
- `temperature`
- `recorded_at`

---

### alerts

Stores building and device alerts.

Main fields include:

- `id`
- `building_id`
- `device_id`
- `type`
- `title`
- `description`
- `created_at`
- `is_resolved`

---

### settings

Stores user-related application settings.

Main fields include:

- `id`
- `user_id`
- `critical_alerts`
- `warning_alerts`
- `device_status`
- `automatic_refresh`
- `compact_dashboard`
- `created_at`

---

## Database Relationships

The database uses foreign keys to maintain relationships between related records.

Main relationships include:

- `users.building_id` → `buildings.id`
- `devices.building_id` → `buildings.id`
- `energy_data.building_id` → `buildings.id`
- `energy_data.device_id` → `devices.id`
- `temperature_data.building_id` → `buildings.id`
- `temperature_data.device_id` → `devices.id`
- `alerts.building_id` → `buildings.id`
- `alerts.device_id` → `devices.id`
- `settings.user_id` → `users.id`

The database uses cascading actions where appropriate to keep related records consistent.

---

## Database Diagram

A database relationship diagram can be added to make the project easier to understand.

Recommended location:

`docs/database-diagram.png`

The diagram should show:

- `buildings`
- `users`
- `devices`
- `energy_data`
- `temperature_data`
- `alerts`
- `settings`
- Primary keys
- Foreign keys
- Relationships between tables

The database diagram is useful for demonstrating relational database design and data modeling.

---

## Project Structure

```text
Smart Building Monitoring Platform/
│
├── api/
│   ├── alerts.php
│   ├── dashboard.php
│   ├── devices.php
│   ├── energy.php
│   ├── profile.php
│   ├── settings.php
│   └── temperature.php
│
├── assets/
│   ├── css/
│   │   ├── login.css
│   │   └── style.css
│   │
│   ├── images/
│   │   ├── building.jpg
│   │   └── flower.jpg
│   │
│   └── js/
│       ├── dashboard.js
│       ├── devices.js
│       ├── energy.js
│       └── settings.js
│
├── config/
│   └── database.php
│
├── database/
│   └── smart_building.sql
│
├── pages/
│   ├── alerts.php
│   ├── devices.php
│   ├── energy.php
│   ├── profile.php
│   └── settings.php
│
├── uploads/
│   └── profile/
│
├── index.php
├── login.php
├── logout.php
├── signup.php
└── README.md
```

---

## Authentication and Security

The application uses PHP sessions for authentication.

After a successful login, basic user information is stored in the session.

Protected pages check whether an authenticated session exists before allowing access.

The API endpoints also check for an authenticated session before returning protected application data.

### Password Security

Passwords are not intentionally stored as plain text.

During registration and password changes, passwords are hashed using:

`password_hash()`

During login, the submitted password is verified using:

`password_verify()`

This provides a safer way to store and verify user passwords.

### SQL Security

Prepared SQL statements are used for database operations involving user-provided values.

This helps reduce the risk of SQL injection when handling submitted form data.

### Session Protection

The following parts of the application are protected by session checks:

- Dashboard
- Devices
- Energy
- Alerts
- Settings
- Profile
- Protected API endpoints

Unauthenticated users are redirected to the login page when accessing protected pages.

---

## Input Validation

The backend performs basic validation for important user inputs.

Examples include:

- Required name validation
- Email format validation
- Password confirmation during registration
- Duplicate email checking
- Required building information
- Profile image format validation
- Profile image size validation

Email addresses are checked using PHP email validation functionality.

Passwords are validated during registration and can be changed from the profile page.

---

## File Uploads

The application supports profile image uploads.

Profile images are stored inside:

`uploads/profile/`

The database stores the relative path to the uploaded profile image.

Supported image formats include:

- JPG
- JPEG
- PNG
- WEBP

The current profile image upload limit is:

**2 MB**

The backend checks the uploaded file before saving it.

When no profile image is available, the interface displays the first letter of the user's name as the profile avatar.

---

## Development Environment

The project was developed and tested locally using:

- XAMPP
- Apache
- MySQL
- phpMyAdmin
- Visual Studio Code

XAMPP was used as the local development environment for running the PHP application and MySQL database.

---

## Technologies Used

### Frontend

- HTML5
- CSS3
- JavaScript
- Chart.js
- Lucide Icons

### Backend

- PHP
- MySQL
- MySQLi
- JSON
- PHP Sessions

### Database

- MySQL
- phpMyAdmin

### Development Tools

- XAMPP
- Apache
- Visual Studio Code
- Git
- GitHub

---

## How to Run the Project

### 1. Install XAMPP

Install XAMPP and make sure Apache and MySQL are available.

---

### 2. Copy the Project

Place the project folder inside the XAMPP `htdocs` directory.

Example:

`C:\xampp\htdocs\Smart Building Monitoring Platform`

---

### 3. Start Apache and MySQL

Open the XAMPP Control Panel.

Start:

- Apache
- MySQL

---

### 4. Create the Database

Open phpMyAdmin.

Create a database named:

`smart_building`

Import the SQL file located at:

`database/smart_building.sql`

---

### 5. Check Database Configuration

Open:

`config/database.php`

Make sure the database connection settings match the local XAMPP configuration.

Typical local development settings may use:

- Host: `localhost`
- User: `root`
- Password: empty
- Database: `smart_building`

These values depend on the local XAMPP configuration.

---

### 6. Open the Application

Open the project through Apache.

Example:

`http://localhost/Smart%20Building%20Monitoring%20Platform/`

The login page should appear first.

---

## Example User Flow

A typical user flow is:

1. Create a new account.
2. Sign in using the registered email and password.
3. Access the protected dashboard.
4. View building monitoring information.
5. View device information.
6. Add, update, or delete devices when required.
7. Check energy information.
8. Check temperature information.
9. Review system alerts.
10. Update profile information.
11. Upload or change a profile picture.
12. Update building settings.
13. Log out from the platform.

---

## Screenshots

Screenshots can be added to show the main parts of the application.

Recommended screenshots:

### Dashboard

Recommended file:

`docs/screenshots/dashboard.png`

The screenshot should show the main dashboard, monitoring cards, charts, alerts, and building overview.

### Device Management

Recommended file:

`docs/screenshots/devices.png`

The screenshot should show the device management interface.

### Energy Monitoring

Recommended file:

`docs/screenshots/energy.png`

The screenshot should show energy and power monitoring information.

### Alerts

Recommended file:

`docs/screenshots/alerts.png`

The screenshot should show the alert management interface.

### Profile

Recommended file:

`docs/screenshots/profile.png`

The screenshot should show the user profile page.

### Settings

Recommended file:

`docs/screenshots/settings.png`

The screenshot should show the building settings page.

---

## Demo

A short GIF or screen recording can be added to demonstrate the main user flow.

Recommended location:

`docs/demo.gif`

A useful demonstration could show:

1. User registration
2. Login
3. Dashboard
4. Device management
5. Monitoring charts
6. Alerts
7. Profile management
8. Building settings
9. Logout

A short demonstration can make the repository easier to understand without requiring the reviewer to run the project immediately.

---

## Development Approach

This project was developed as a personal academic and portfolio project.

The application was intentionally built using fundamental technologies such as PHP, MySQL, JavaScript, HTML, and CSS.

The purpose of this approach was to gain a stronger understanding of how the different parts of a web application work together.

The project was developed step by step.

The development process included:

1. Designing the database structure
2. Creating the frontend pages
3. Connecting PHP to MySQL
4. Building API endpoints
5. Implementing authentication
6. Protecting pages with sessions
7. Protecting API endpoints
8. Adding device CRUD operations
9. Adding monitoring data
10. Adding alert functionality
11. Adding profile management
12. Adding profile image uploads
13. Adding building settings
14. Checking database relationships
15. Testing the main application flows

The project was kept relatively simple so that the backend logic and database relationships remain understandable.

---

## What I Learned

This project helped me gain practical experience in several areas of web development.

### Backend Development

- PHP server-side programming
- Handling HTTP requests
- Processing forms
- Working with PHP sessions
- Returning JSON responses
- Building simple API endpoints
- Connecting PHP to MySQL
- Performing CRUD operations

### Database Development

- Relational database design
- Creating database tables
- Primary keys
- Foreign keys
- Database relationships
- SQL queries
- CRUD operations
- Cascading relationships
- Connecting application data to relational tables

### Authentication

- User registration
- Login systems
- Password hashing
- Password verification
- Session management
- Protected pages
- Protected API endpoints

### Frontend Development

- HTML page structure
- CSS layout and styling
- JavaScript interactions
- Chart.js visualization
- Frontend-backend communication
- Search functionality
- User interface consistency
- Responsive layout considerations

### File Handling

- PHP file uploads
- Image validation
- File size validation
- Storing uploaded files
- Saving file paths in a database

---

## Challenges

During development, several practical challenges were addressed.

### Connecting Frontend and Backend

One of the main challenges was understanding how JavaScript frontend pages communicate with PHP backend APIs.

The project helped demonstrate how:

- JavaScript sends requests
- PHP receives requests
- PHP communicates with MySQL
- MySQL returns data
- PHP returns JSON
- JavaScript displays the returned information

### Authentication and Password Security

Another important part was implementing authentication without storing passwords as plain text.

The registration and profile functionality was updated to use password hashing, while the login system verifies passwords using PHP's password verification functionality.

### Database Relationships

The project also required understanding how different building-related records should be connected.

Foreign keys were used to connect users, buildings, devices, energy data, temperature data, alerts, and settings.

### File Uploads

Profile image uploads required handling:

- File size limits
- Supported extensions
- Upload errors
- File storage
- Database image paths

The upload system was tested locally using the PHP/XAMPP environment.

---

## Future Improvements

Possible future improvements include:

- Real-time sensor data integration
- More advanced energy analytics
- More detailed historical charts
- Additional alert management features
- Role-based access control
- More detailed device information
- Improved mobile responsiveness
- Automated sensor data collection
- Exporting monitoring data
- More advanced building analytics

These are potential future improvements and are not currently presented as implemented features.

---

## Project Status

The current version of the project includes:

- Frontend dashboard
- Device management
- Energy monitoring
- Temperature monitoring
- Alert management
- User authentication
- Session-based page protection
- Protected API endpoints
- Password hashing
- User profile management
- Profile image upload
- Building settings
- MySQL database
- Relational database structure
- Foreign key relationships
- PHP APIs
- Frontend-backend integration

The project is functional as a local academic and portfolio application and can be further extended with real sensor data and additional smart-building functionality.

---

## Portfolio Purpose

This project was developed as a personal academic and portfolio project to demonstrate practical experience with:

- Web application development
- Backend programming
- PHP
- MySQL
- Database design
- REST-style API concepts
- Authentication
- Session management
- CRUD operations
- Frontend-backend integration
- Data visualization
- File handling

The project is particularly intended to demonstrate the ability to build a complete small-scale web application from database design to frontend presentation.

---

## Academic Context

The project is also intended to support Master's application materials by demonstrating practical technical experience and an interest in software development, data-driven systems, and smart-building technologies.

Rather than presenting the project as a production-scale smart building system, it is designed as an academic and portfolio implementation that demonstrates the fundamentals of building a connected monitoring platform.

---

## Author

Saina Gouran

Graduate student interested in software development, data-driven systems, and smart technologies.
Developed as a personal academic and portfolio project.

---

## License

This project is intended for academic, educational, and portfolio purposes.
