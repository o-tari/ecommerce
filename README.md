## 🚀 Ecommerce with TALL stack

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

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).


# Ecommerce API Documentation

## Overview
This document provides comprehensive documentation for the Ecommerce API v1. The API is built with Laravel and follows RESTful conventions.

**Base URL:** `http://your-domain.com/api/v1`

## Authentication
The API uses Laravel Sanctum for authentication. Most endpoints require authentication via Bearer token.

### Getting Started
1. Register a new user account
2. Login to get an access token
3. Include the token in the Authorization header: `Authorization: Bearer {token}`

## Response Format
All API responses follow a consistent format:

### Success Response
```json
{
    "success": true,
    "message": "Success message",
    "data": { ... }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": { ... }
}
```

## Endpoints

### Authentication

#### 1. User Registration
**POST** `/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "created_at": "2024-01-01T00:00:00.000000Z"
        },
        "token": "1|abc123..."
    }
}
```

#### 2. User Login
**POST** `/login`

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": { ... },
        "token": "2|def456..."
    }
}
```

#### 3. User Logout
**POST** `/logout`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Logged out successfully",
    "data": null
}
```

#### 4. Revoke Token
**POST** `/revoke-token`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "token_id": "2|def456..."
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Token revoked successfully",
    "data": null
}
```

#### 5. Get Authenticated User
**GET** `/user`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "User retrieved successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "email_verified_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

### Products

#### 1. List Products
**GET** `/products`

**Query Parameters:**
- `published` (boolean): Filter by published status
- `product_type` (string): Filter by product type
- `search` (string): Search in product name or SKU
- `sort_by` (string): Sort field (default: created_at)
- `sort_direction` (string): asc/desc (default: desc)
- `per_page` (integer): Items per page (default: 15)

**Example Request:**
```
GET /api/v1/products?published=1&search=laptop&sort_by=price&sort_direction=asc&per_page=20
```

**Response (200):**
```json
{
    "success": true,
    "message": "Products retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "product_name": "Gaming Laptop",
                "slug": "gaming-laptop",
                "sku": "LAP001",
                "sale_price": "1299.99",
                "compare_price": "1499.99",
                "quantity": 50,
                "published": true,
                "categories": [...],
                "tags": [...],
                "suppliers": [...]
            }
        ],
        "total": 25,
        "per_page": 20
    }
}
```

#### 2. Create Product
**POST** `/products`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "product_name": "New Gaming Laptop",
    "slug": "new-gaming-laptop",
    "sku": "LAP002",
    "sale_price": "1399.99",
    "compare_price": "1599.99",
    "buying_price": "1100.00",
    "quantity": 30,
    "short_description": "High-performance gaming laptop",
    "product_description": "Detailed description...",
    "published": true,
    "disable_out_of_stock": false,
    "categories": [1, 2],
    "tags": [1, 3],
    "suppliers": [1]
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Product created successfully",
    "data": {
        "id": 2,
        "product_name": "New Gaming Laptop",
        "slug": "new-gaming-laptop",
        "sku": "LAP002",
        "sale_price": "1399.99",
        "created_by": 1,
        "categories": [...],
        "tags": [...],
        "suppliers": [...]
    }
}
```

#### 3. Get Product
**GET** `/products/{id}`

**Response (200):**
```json
{
    "success": true,
    "message": "Product retrieved successfully",
    "data": {
        "id": 1,
        "product_name": "Gaming Laptop",
        "slug": "gaming-laptop",
        "sku": "LAP001",
        "sale_price": "1299.99",
        "variants": [...],
        "product_attributes": [...],
        "categories": [...],
        "tags": [...],
        "suppliers": [...]
    }
}
```

#### 4. Update Product
**PUT** `/products/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:** Same as create, but all fields are optional

**Response (200):**
```json
{
    "success": true,
    "message": "Product updated successfully",
    "data": { ... }
}
```

#### 5. Delete Product
**DELETE** `/products/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Product deleted successfully",
    "data": null
}
```

**Note:** Cannot delete products with items.

### Categories

#### 1. List Categories
**GET** `/categories`

**Query Parameters:**
- `active` (boolean): Filter by active status
- `parent_id` (integer|null): Filter by parent category (use 'null' for root categories)
- `search` (string): Search in category name
- `sort_by` (string): Sort field (default: category_name)
- `sort_direction` (string): asc/desc (default: asc)
- `per_page` (integer): Items per page (default: 15)

**Example Request:**
```
GET /api/v1/categories?active=1&parent_id=null&sort_by=category_name&sort_direction=asc
```

**Response (200):**
```json
{
    "success": true,
    "message": "Categories retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "category_name": "Electronics",
                "slug": "electronics",
                "description": "Electronic devices and accessories",
                "active": true,
                "parent": null,
                "children": [
                    {
                        "id": 2,
                        "category_name": "Laptops",
                        "slug": "laptops"
                    }
                ]
            }
        ]
    }
}
```

#### 2. Create Category
**POST** `/categories`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "category_name": "Smartphones",
    "slug": "smartphones",
    "description": "Mobile phones and accessories",
    "parent_id": 1,
    "active": true
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Category created successfully",
    "data": {
        "id": 3,
        "category_name": "Smartphones",
        "slug": "smartphones",
        "parent_id": 1,
        "active": true
    }
}
```

#### 3. Get Category
**GET** `/categories/{id}`

**Response (200):**
```json
{
    "success": true,
    "message": "Category retrieved successfully",
    "data": {
        "id": 1,
        "category_name": "Electronics",
        "slug": "electronics",
        "parent": null,
        "children": [...],
        "products": [...]
    }
}
```

#### 4. Update Category
**PUT** `/categories/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:** Same as create, but all fields are optional

**Response (200):**
```json
{
    "success": true,
    "message": "Category updated successfully",
    "data": { ... }
}
```

#### 5. Delete Category
**DELETE** `/categories/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Category deleted successfully",
    "data": null
}
```

**Note:** Cannot delete categories with subcategories or products.

### Users

#### 1. List Users
**GET** `/users`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `search` (string): Search in name or email
- `sort_by` (string): Sort field (default: created_at)
- `sort_direction` (string): asc/desc (default: desc)
- `per_page` (integer): Items per page (default: 15)

**Response (200):**
```json
{
    "success": true,
    "message": "Users retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "John Doe",
                "email": "john@example.com",
                "email_verified_at": "2024-01-01T00:00:00.000000Z",
                "roles": [
                    {
                        "id": 1,
                        "name": "admin"
                    }
                ]
            }
        ]
    }
}
```

#### 2. Create User
**POST** `/users`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "Jane Smith",
    "email": "jane@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "roles": ["editor"]
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "User created successfully",
    "data": {
        "id": 2,
        "name": "Jane Smith",
        "email": "jane@example.com",
        "roles": [...]
    }
}
```

#### 3. Get User
**GET** `/users/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "User retrieved successfully",
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "roles": [...],
        "permissions": [...]
    }
}
```

#### 4. Update User
**PUT** `/users/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "John Updated",
    "email": "john.updated@example.com",
    "password": "newpassword123",
    "password_confirmation": "newpassword123",
    "roles": ["admin", "editor"]
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "User updated successfully",
    "data": { ... }
}
```

#### 5. Delete User
**DELETE** `/users/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "User deleted successfully",
    "data": null
}
```

**Note:** Cannot delete your own account.

### Orders

#### 1. List Orders
**GET** `/orders`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `order_status_id` (integer): Filter by order status
- `user_id` (integer): Filter by customer
- `payment_status` (string): Filter by payment status
- `search` (string): Search in order number or customer ID
- `sort_by` (string): Sort field (default: created_at)
- `sort_direction` (string): asc/desc (default: desc)
- `per_page` (integer): Items per page (default: 15)

**Response (200):**
```json
{
    "success": true,
    "message": "Orders retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "order_number": "ORD-001",
                "customer_id": 1,
                "order_status_id": 1,
                "payment_status": "paid",
                "total_amount": "1299.99",
                "customer": { ... },
                "order_status": { ... },
                "order_items": [...]
            }
        ]
    }
}
```

#### 2. Create Order
**POST** `/orders`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "order_number": "ORD-002",
    "customer_id": 1,
    "order_status_id": 1,
    "payment_status": "pending",
    "total_amount": "899.99",
    "shipping_address": "123 Main St",
    "billing_address": "123 Main St"
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Order created successfully",
    "data": {
        "id": 2,
        "order_number": "ORD-002",
        "customer_id": 1,
        "total_amount": "899.99"
    }
}
```

#### 3. Get Order
**GET** `/orders/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Order retrieved successfully",
    "data": {
        "id": 1,
        "order_number": "ORD-001",
        "customer": { ... },
        "order_status": { ... },
        "order_items": [
            {
                "id": 1,
                "product_id": 1,
                "quantity": 2,
                "price": "649.99",
                "product": { ... }
            }
        ]
    }
}
```

#### 4. Update Order
**PUT** `/orders/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:** Same as create, but all fields are optional

**Response (200):**
```json
{
    "success": true,
    "message": "Order updated successfully",
    "data": { ... }
}
```

#### 5. Delete Order
**DELETE** `/orders/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Order deleted successfully",
    "data": null
}
```

**Note:** Cannot delete orders with items.

### Variants

#### 1. List Variants
**GET** `/variants`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `product_id` (integer): Filter by product
- `is_active` (boolean): Filter by active status
- `search` (string): Search in SKU
- `sort_by` (string): Sort field (default: created_at)
- `sort_direction` (string): asc/desc (default: desc)
- `per_page` (integer): Items per page (default: 15)

**Response (200):**
```json
{
    "success": true,
    "message": "Variants retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "sku": "LAP001-BLK",
                "price": "1299.99",
                "quantity": 25,
                "is_active": true,
                "product": { ... },
                "variant_values": [...]
            }
        ]
    }
}
```

#### 2. Create Variant
**POST** `/variants`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "product_id": 1,
    "variant_option": "Black Color",
    "variant_option_id": 1,
    "sku": "LAP001-BLK",
    "price": "1299.99",
    "quantity": 25,
    "weight": "2.5",
    "is_active": true
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Variant created successfully",
    "data": {
        "id": 1,
        "sku": "LAP001-BLK",
        "price": "1299.99",
        "product_id": 1
    }
}
```

#### 3. Get Variant
**GET** `/variants/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Variant retrieved successfully",
    "data": {
        "id": 1,
        "sku": "LAP001-BLK",
        "price": "1299.99",
        "product": { ... },
        "variant_values": [
            {
                "id": 1,
                "attribute": { ... },
                "attribute_value": { ... }
            }
        ]
    }
}
```

#### 4. Update Variant
**PUT** `/variants/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:** Same as create, but all fields are optional

**Response (200):**
```json
{
    "success": true,
    "message": "Variant updated successfully",
    "data": { ... }
}
```

#### 5. Delete Variant
**DELETE** `/variants/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Variant deleted successfully",
    "data": null
}
```

### Coupons

#### 1. List Coupons
**GET** `/coupons`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `is_active` (boolean): Filter by active status
- `discount_type` (string): Filter by discount type
- `search` (string): Search in code or name
- `sort_by` (string): Sort field (default: created_at)
- `sort_direction` (string): asc/desc (default: desc)
- `per_page` (integer): Items per page (default: 15)

**Response (200):**
```json
{
    "success": true,
    "message": "Coupons retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "code": "SAVE20",
                "name": "20% Off",
                "discount_type": "percentage",
                "discount_value": "20.00",
                "is_active": true,
                "products": [...]
            }
        ]
    }
}
```

#### 2. Create Coupon
**POST** `/coupons`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "code": "SAVE20",
    "name": "20% Off",
    "description": "Get 20% off on all products",
    "discount_type": "percentage",
    "discount_value": "20.00",
    "minimum_amount": "100.00",
    "maximum_discount": "200.00",
    "usage_limit": 100,
    "valid_from": "2024-01-01",
    "valid_until": "2024-12-31",
    "is_active": true
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Coupon created successfully",
    "data": {
        "id": 1,
        "code": "SAVE20",
        "name": "20% Off",
        "discount_type": "percentage"
    }
}
```

#### 3. Get Coupon
**GET** `/coupons/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Coupon retrieved successfully",
    "data": {
        "id": 1,
        "code": "SAVE20",
        "name": "20% Off",
        "products": [...]
    }
}
```

#### 4. Update Coupon
**PUT** `/coupons/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:** Same as create, but all fields are optional

**Response (200):**
```json
{
    "success": true,
    "message": "Coupon updated successfully",
    "data": { ... }
}
```

#### 5. Delete Coupon
**DELETE** `/coupons/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Coupon deleted successfully",
    "data": null
}
```

**Note:** Cannot delete coupons with associated products.

### Tags

#### 1. List Tags
**GET** `/tags`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `search` (string): Search in tag name
- `sort_by` (string): Sort field (default: name)
- `sort_direction` (string): asc/desc (default: asc)
- `per_page` (integer): Items per page (default: 15)

**Response (200):**
```json
{
    "success": true,
    "message": "Tags retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "Gaming",
                "slug": "gaming",
                "description": "Gaming related products",
                "products": [...]
            }
        ]
    }
}
```

#### 2. Create Tag
**POST** `/tags`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "Gaming",
    "slug": "gaming",
    "description": "Gaming related products"
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Tag created successfully",
    "data": {
        "id": 1,
        "name": "Gaming",
        "slug": "gaming"
    }
}
```

#### 3. Get Tag
**GET** `/tags/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Tag retrieved successfully",
    "data": {
        "id": 1,
        "name": "Gaming",
        "slug": "gaming",
        "products": [...]
    }
}
```

#### 4. Update Tag
**PUT** `/tags/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:** Same as create, but all fields are optional

**Response (200):**
```json
{
    "success": true,
    "message": "Tag updated successfully",
    "data": { ... }
}
```

#### 5. Delete Tag
**DELETE** `/tags/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response (200):**
```json
{
    "success": true,
    "message": "Tag deleted successfully",
    "data": null
}
```

**Note:** Cannot delete tags with associated products.

### Additional Resources

The API also includes endpoints for:
- **Suppliers** - `/suppliers`
- **Attributes** - `/attributes`
- **Slideshows** - `/slideshows`
- **Cards** - `/cards`
- **Countries** - `/countries`
- **Shipping** - `/shipping-zones`, `/shipping-rates`

All follow the same RESTful pattern with similar query parameters, pagination, and response formats.

## Error Handling

### Common HTTP Status Codes
- **200** - Success
- **201** - Created
- **400** - Bad Request
- **401** - Unauthorized
- **403** - Forbidden
- **404** - Not Found
- **409** - Conflict
- **422** - Validation Error
- **500** - Internal Server Error

### Validation Errors
When validation fails, the API returns a 422 status with detailed error messages:

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

## Rate Limiting
The API implements rate limiting to prevent abuse. Please respect the limits and implement appropriate retry logic in your applications.

## Pagination
All list endpoints support pagination with the following parameters:
- `per_page`: Number of items per page (default: 15, max: 100)
- `page`: Page number (default: 1)

Response includes pagination metadata:
```json
{
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 75,
    "from": 1,
    "to": 15
}
```

## Testing
You can test the API endpoints using tools like:
- Postman
- Insomnia
- cURL
- Any HTTP client library

Remember to include the `Authorization: Bearer {token}` header for protected endpoints.

### User Dashboard Statistics

#### 1. Get User Dashboard Statistics
**GET** `/user/dashboard/statistics`

**Headers:** `Authorization: Bearer {token}`

**Description:** Retrieves various statistics for the authenticated user's dashboard, including order summaries, active orders, available coupons, top purchased items, and return history.

**Response (200):**
```json
{
    "total_orders_placed": 3,
    "total_amount_spent": "350.50",
    "average_order_value": "116.83",
    "orders_last_30_days": 2,
    "active_orders": [
        {
            "order_number": "ORD-XYZ123",
            "total_amount": "50.00",
            "status": "pending",
            "estimated_delivery_date": "2025-10-15",
            "created_at": "2025-09-20"
        }
    ],
    "available_coupons": [
        {
            "code": "SAVE10",
            "discount": "10%",
            "expires_on": "2025-10-31"
        }
]
,
    "top_purchased_items": [
        {
            "product_name": "Product A",
            "total_quantity": 8,
            "image_url": "http://example.com/a.jpg"
        }
    ],
    "returned_orders_count": 1
}
```

**Response (401):**
```json
{
    "message": "Unauthenticated."
}
```
