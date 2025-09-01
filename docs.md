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
- `customer_id` (integer): Filter by customer
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
- **Customers** - `/customers`
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

