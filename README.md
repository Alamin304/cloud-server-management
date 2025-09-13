# Cloud Server Management

A full-stack web application for managing cloud servers built with Laravel, MySQL, and Blade templating.

## Features

- **Server CRUD Operations**: Create, read, update, and delete servers
- **Authentication**: User registration and login system
- **API**: RESTful API with authentication
- **Search and Filter**: Filter servers by name, IP, provider, and status
- **Bulk Operations**: Delete multiple servers at once
- **Responsive Design**: Works on desktop and mobile devices

## Tech Stack

- **Backend**: Laravel 12.x
- **Frontend**: Blade templating with Bootstrap 5
- **Database**: MySQL
- **Authentication**: Laravel Sanctum for API, Laravel UI for web

## Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd cloud-server-management


Install dependencies:
bash
composer install
npm install

Create environment file:
bash
cp .env.example .env

Generate application key:
bash
php artisan key:generate

Configure database in .env:
env
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

Run migrations and seeders:
bash
php artisan migrate
php artisan db:seed

Install and build frontend assets:
bash
npm run dev

Start the development server:
bash
php artisan serve
Visit http://localhost:8000 in your browser.

API Documentation
Authentication
The API uses Laravel Sanctum for authentication. To authenticate:

Register a user via the web interface or API

Get an API token by logging in via /login endpoint

Include the token in the Authorization header as Bearer {token}

Endpoints
GET /api/servers - List all servers (with pagination, filtering, and sorting)

POST /api/servers - Create a new server

GET /api/servers/{id} - Get a specific server

PUT /api/servers/{id} - Update a server

DELETE /api/servers/{id} - Delete a server

POST /api/servers/bulk-delete - Bulk delete servers


Example API Usage

# Get all servers
curl -H "Authorization: Bearer {token}" http://localhost:8000/api/servers

# Create a new server
curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer {token}" \
  -d '{
    "name": "api-server",
    "ip_address": "192.168.1.200",
    "provider": "aws",
    "status": "active",
    "cpu_cores": 4,
    "ram_mb": 8192,
    "storage_gb": 100
  }' \
  http://localhost:8000/api/servers

# Update a server
curl -X PUT -H "Content-Type: application/json" -H "Authorization: Bearer {token}" \
  -d '{
    "name": "updated-api-server",
    "ip_address": "192.168.1.200",
    "provider": "aws",
    "status": "active",
    "cpu_cores": 8,
    "ram_mb": 16384,
    "storage_gb": 200
  }' \
  http://localhost:8000/api/servers/1

# Delete a server
curl -X DELETE -H "Authorization: Bearer {token}" http://localhost:8000/api/servers/1
