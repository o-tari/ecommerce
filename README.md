# Ecommerce API

## 📚 API Documentation

**📖 [View Full API Documentation](docs.md)**

This project includes comprehensive API documentation covering all endpoints, authentication, request/response formats, and examples. Click the link above to view the complete API reference.

---

## 🚀 Project Overview

A modern ecommerce API built with Laravel, featuring:

- **RESTful API** with comprehensive endpoints
- **Laravel Sanctum** authentication
- **Product management** with variants and attributes
- **Order processing** and management
- **Category and tag** organization
- **Coupon system** for discounts
- **User management** with role-based access
- **Shipping and inventory** management

## 🛠️ Tech Stack

- **Backend:** Laravel 11
- **Database:** SQLite (development), MySQL/PostgreSQL (production)
- **Authentication:** Laravel Sanctum
- **Admin Panel:** Filament
- **Testing:** Pest PHP
- **Frontend:** Livewire + Blade

## 📋 Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM
- Git

## ⚡ Quick Start

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd ecommerce
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

## 🔐 API Authentication

The API uses Laravel Sanctum for authentication. Most endpoints require a Bearer token:

```bash
Authorization: Bearer {your-token}
```

Get your token by:
1. Registering a new account: `POST /api/v1/register`
2. Logging in: `POST /api/v1/login`

## 🧪 Testing

Run the test suite with:

```bash
php artisan test
```

Or use the provided script:

```bash
./run_tests.sh
```

## 📖 Documentation

- **API Reference:** [docs.md](docs.md) - Complete API documentation
- **Laravel Docs:** [laravel.com/docs](https://laravel.com/docs)
- **Filament Docs:** [filamentphp.com/docs](https://filamentphp.com/docs)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

**Need help?** Check the [API Documentation](docs.md) first, then open an issue for additional support.
