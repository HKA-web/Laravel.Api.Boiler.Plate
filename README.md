# Laravel API Boilerplate

![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red)
![PHP Version](https://img.shields.io/badge/PHP-8.2-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Tests](https://img.shields.io/badge/tests-Pest-green)
![Code Quality](https://img.shields.io/badge/analysis-PHPStan-blue)

This repository provides a production-ready boilerplate for creating RESTful APIs using Laravel 12, with a focus on clean, maintainable code. It leverages Actions, Data Transfer Objects (DTOs), API Resources, and modern best practices to ensure a scalable and well-documented architecture.

## Getting Started

### Prerequisites

-   PHP 8.2 or higher
-   Composer
-   Laravel 12.x
-   MySQL or any other supported database

### Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/holiq/api-boilerplate.git
    ```

2. **Navigate to the project directory:**

    ```bash
    cd api-boilerplate
    ```

3. **Install dependencies:**

    ```bash
    composer install --prefer-dist
    ```

4. **Set up environment variables:**

    Copy the `.env.example` file to `.env` and configure your database settings.

    ```bash
    cp .env.example .env
    ```

5. **Generate application key:**

    ```bash
    php artisan key:generate
    ```

6. **Run migrations:**

    ```bash
    php artisan migrate
    ```

7. **Seed the database (optional):**

    ```bash
    php artisan db:seed
    ```

### Running the API

Start the development server:

```bash
php artisan serve
```

The API will be accessible at `http://localhost:8000/api`.

### API Documentation

This boilerplate includes auto-generated API documentation using Scramble. Once your server is running, you can access the interactive API documentation at:

```
http://localhost:8000/docs/api
```

The OpenAPI specification is available at:

```
http://localhost:8000/docs/api.json
```

### Creating New Features

1. **Generate CRUD:**
    ```bash
    php artisan make:api-crud <name module>
    ```
    
2. **Generate Temporary:**
    ```bash
    make:api-temporary-crud <name module>
    ```
    
3. **Register your route in file :  routes/auth.php **

### Authentication

The API uses Laravel Sanctum for authentication. After successful login, you'll receive a token that should be included in subsequent requests:

```bash
Authorization: Bearer {your-token-here}
```

### Response Format

All API responses follow a consistent format:

**Success Response:**

```json
{
  "skip": 0,
  "take": 10,
  "totalCount": 1,
  "execution": 1.36,
  "data": [
    {
      "company_id": "tes",
      "status": "string",
      "is_removed": false
    }
  ]
}
```

**Error Response:**

```json
{
  "error": [
    {
      "file": "/media/Data/Projects/ERP/api-boiler/vendor/laravel/framework/src/Illuminate/Database/Connection.php",
      "line": 778,
      "function": "runQueryCallback",
      "class": "Illuminate\\Database\\Connection",
      "type": "->"
    },{...}
  ]
}
```

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork this repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Run tests and ensure code quality (`php artisan test && vendor/bin/pint && vendor/bin/phpstan analyse`)
5. Push to the branch (`git push origin feature/amazing-feature`)
6. Open a Pull Request

Please ensure your code follows the existing style and includes appropriate tests.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Security

If you discover any security-related issues, please email the maintainer instead of using the issue tracker.
