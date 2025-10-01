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
   - **Admin Panel:** Filament (using `App\Filament\Resources` for managing database resources)

## ⚙️ Filament Resources

The Filament admin panel uses the following resources to manage different aspects of the application:
- **UserResource**: Manages the `User` model, for user administration and role assignment.
  <img width="1163" height="487" alt="Screenshot 2025-10-01 at 12 58 59 PM" src="https://github.com/user-attachments/assets/a9b23cb6-c2a2-409d-8cd7-6f1126ab1196" />
<img width="1157" height="487" alt="Screenshot 2025-10-01 at 12 59 16 PM" src="https://github.com/user-attachments/assets/45bd24ae-5a02-472d-a6a6-03332552563d" />
- **ProductResource**: Manages the `Product` model, for comprehensive product management including details, pricing, and inventory.
  <img width="1160" height="428" alt="Screenshot 2025-10-01 at 12 59 56 PM" src="https://github.com/user-attachments/assets/137e9702-cdb1-4bfc-927d-b305bb517d3c" />
<img width="1135" height="714" alt="Screenshot 2025-10-01 at 1 00 19 PM" src="https://github.com/user-attachments/assets/b47835e1-9468-4888-8fc2-07dc3e19e673" />
<img width="1155" height="547" alt="Screenshot 2025-10-01 at 1 00 34 PM" src="https://github.com/user-attachments/assets/afb64d6a-38a7-4a55-a4a1-eb23fc26ed9c" />
<img width="1146" height="686" alt="Screenshot 2025-10-01 at 1 01 33 PM" src="https://github.com/user-attachments/assets/bfaf1ab2-a827-4da8-9819-5f38fdd26726" />

- **OrderResource**: Manages the `Order` model, for viewing and updating customer orders.
<img width="1152" height="388" alt="Screenshot 2025-10-01 at 1 02 00 PM" src="https://github.com/user-attachments/assets/37c94071-6176-418e-8dff-5b58c097e43d" />
<img width="1142" height="672" alt="Screenshot 2025-10-01 at 1 02 14 PM" src="https://github.com/user-attachments/assets/7ace493b-23bd-4c00-9d1e-84f9ff6ffb9d" />
<img width="1142" height="267" alt="Screenshot 2025-10-01 at 1 02 35 PM" src="https://github.com/user-attachments/assets/80341281-27db-4a92-bd6c-ccdf9ea40c1e" />

- **AttributeResource**: Manages the `Attribute` model, used for defining product attributes.
<img width="1166" height="462" alt="Screenshot 2025-10-01 at 12 55 56 PM" src="https://github.com/user-attachments/assets/a6db641d-7c31-4237-9d93-c28b383205b5" />
<img width="1163" height="350" alt="Screenshot 2025-10-01 at 12 56 17 PM" src="https://github.com/user-attachments/assets/d5fe166a-4241-48ae-afea-587c5c3e524a" />


- **CategoryResource**: Manages the `Category` model, for organizing products into categories.
<img width="1161" height="431" alt="Screenshot 2025-10-01 at 12 56 43 PM" src="https://github.com/user-attachments/assets/1196c070-8921-417b-b324-8cfa2b1dbd5c" />
<img width="1176" height="603" alt="Screenshot 2025-10-01 at 12 57 04 PM" src="https://github.com/user-attachments/assets/6efd5fb1-1bd1-4302-ab30-de3a0f9deaad" />

- **CouponResource**: Manages the `Coupon` model, for creating and managing discount coupons.
<img width="1159" height="420" alt="Screenshot 2025-10-01 at 12 57 40 PM" src="https://github.com/user-attachments/assets/56eba355-0928-4243-9ebc-bf5e7cee856a" />
<img width="1166" height="583" alt="Screenshot 2025-10-01 at 12 57 56 PM" src="https://github.com/user-attachments/assets/8c9b3e98-bc29-4db0-9a0c-bedbf9aaecb4" />
- **SlideshowResource**: Manages the `Slideshow` model, for controlling homepage slideshow content.
- **SupplierResource**: Manages the `Supplier` model, for tracking product suppliers.
- **TagResource**: Manages the `Tag` model, for categorizing products with tags.
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
