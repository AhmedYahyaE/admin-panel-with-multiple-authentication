# Admin Panel with Multiple Authentication and Role-Based Access

This is an Admin Panel with Multiple Authentication and Role-Based Access application built with **Laravel 11** with the help of Spatie Laravel Permission package. The admin panel supports multi-authentication, with at least three types of users: admin, supervisor, and regular user roles. Admins have full access to all features and settings, while supervisor and regular users roles have limited access based on their assigned roles and permissions.


## Installation Instructions

Follow the steps below to set up and run the application locally.


### Steps to Install

1. **Clone the repository**:
    ```bash
    git clone https://github.com/AhmedYahyaE/admin-panel-with-multiple-authentication.git
    cd admin-panel-with-multiple-authentication-main
    ```

2. **Install dependencies**:
    ```bash
    composer install
    ```

3. **Set up the environment file**:
    Copy `.env.example` to `.env`:
    ```bash
    cp .env.example .env
    ```

4. **Generate the application key**:  
    This step generates a unique application key for encryption:  
    ```bash
    php artisan key:generate
    ```

5. **Configure the database**:
    Open the `.env` file and set your database credentials:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```

6. **Import the database:**:
    Create a MySQL database named `admin_panel_with_multiple_authentication`, then import the admin_panel_with_multiple_authentication database SQL Dump File from the path: 'database/admin_panel_with_multiple_authentication.sql' into your `admin_panel_with_multiple_authentication` database.

7. **Install frontend dependencies**:
    ```bash
    npm install
    ```

8. **Build Vite assets** (for frontend):
    ```bash
    npm run build
    ```

9. **Start the Laravel development server**:
    ```bash
    php artisan serve
    ```

Now, your application should be running locally at `http://localhost:8000`. To experiment with the application, use the following existing users: 
- An 'admin' role user: Email: ahmed.yahya@example-email.com, Password: 123456
- A 'supervisor' role user: Email: samir.sobhy@example-email.com, Password: 123456
- A 'regular user' role user: Email: hesham.rafla@example-email.com, Password: 123456
