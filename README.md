# Penjualan Kendaraan Restfull API


# Prerequisites
Before running the project, make sure you have the following installed on your system:

- PHP 8
- Composer
- MongoDB 4.2 or higher

## Installation
1. Clone the repository:
    ```sh
    git clone https://github.com/rizqiaditia27/penjualan-kendaraanAPI.git
    ```
2. Navigate to the project directory:
3. Install the dependencies using Composer:
    ```sh
    composer install
    ```
4. Update the MongoDB connection details in the .env file:
     ```sh
    DB_CONNECTION=mongodb
    DB_HOST=127.0.0.1
    DB_PORT=27017
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```
5. Generate an application key:
    ```sh
    php artisan key:generate
    ```
6. Generate a JWT secret key:
     ```sh
    php artisan jwt:secret
    ```
7. Start the development server:
     ```sh
    php artisan serve
    ```