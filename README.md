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

---

## Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd cloud-server-management

2. **Install dependencies**

```bash
composer install
npm install
npm run dev
```

3. **Copy `.env` file**

```bash
cp .env.example .env
```

4. **Generate application key**

```bash
php artisan key:generate
```

5. **Configure database** in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Run migrations and seeders**

```bash
php artisan migrate --seed
```

7. **Serve the application**

```bash
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

---

## Configuration

* **Mail Setup** (Optional for notifications):

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_email@example.com
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

* **API Tokens**: Use **Laravel Sanctum** for API authentication. Generate tokens for users to access endpoints.

---

## Usage

1. **Dashboard**: View all servers, filter by provider, name, or status.
2. **Add Server**: Fill in server details, including name, IP, provider, and resources.
3. **Edit Server**: Update server details with validation.
4. **Delete Server**: Remove servers individually or in bulk.
5. **API**: Access all CRUD operations programmatically using your API token.

---

## API Endpoints

| Method | Endpoint            | Description         |
| ------ | ------------------- | ------------------- |
| GET    | `/api/servers`      | List all servers    |
| POST   | `/api/servers`      | Create a new server |
| GET    | `/api/servers/{id}` | Get server details  |
| PUT    | `/api/servers/{id}` | Update server       |
| DELETE | `/api/servers/{id}` | Delete server       |

> Requires **Sanctum token** for authentication.

---

## Testing

Run tests using PHPUnit:

```bash
php artisan test
```

Test coverage includes:

* Server CRUD operations
* Form validation
* API endpoint functionality

---

