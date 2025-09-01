# E-commerce REST API Documentation

## Overview

This document provides comprehensive documentation for the E-commerce REST API built with Laravel and Laravel Sanctum. The API provides token-based authentication and full CRUD operations for all e-commerce entities.

## Base URL

```
https://yourdomain.com/api/v1
```

## Authentication

The API uses Laravel Sanctum for token-based authentication. All protected endpoints require a valid Bearer token in the Authorization header.

### Authentication Workflow

1. **Register** - Create a new user account
2. **Login** - Authenticate and receive access token
3. **Use Token** - Include token in Authorization header for protected requests
4. **Logout/Revoke** - Invalidate tokens when done

### Headers

```
Authorization: Bearer {your_token_here}
Content-Type: application/json
Accept: application/json
```

## Response Format

All API responses follow a consistent format:

```json
{
  "success": true,
  "message": "Operation completed successfully",
  "data": {
    // Response data here
  }
}
```

Error responses:

```json
{
  "success": false,
  "message": "Error description",
  "errors": {
    // Validation errors if applicable
  }
}
```

## Authentication Endpoints

### Register User

**POST** `/api/v1/register`

Create a new user account.

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2025-08-31T17:50:19.000000Z",
      "updated_at": "2025-08-31T17:50:19.000000Z"
    },
    "token": "1|abc123..."
  }
}
```

**cURL Example:**
```bash
curl -X POST https://yourdomain.com/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login User

**POST** `/api/v1/login`

Authenticate user and receive access token.

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "token": "1|abc123..."
  }
}
```

**cURL Example:**
```bash
curl -X POST https://yourdomain.com/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

### Get Current User

**GET** `/api/v1/user`

Get authenticated user information.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "User retrieved successfully",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2025-08-31T17:50:19.000000Z",
    "updated_at": "2025-08-31T17:50:19.000000Z"
  }
}
```

**cURL Example:**
```bash
curl -X GET https://yourdomain.com/api/v1/user \
  -H "Authorization: Bearer {your_token_here}"
```

### Logout User

**POST** `/api/v1/logout`

Invalidate current access token.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "Logged out successfully",
  "data": null
}
```

**cURL Example:**
```bash
curl -X POST https://yourdomain.com/api/v1/logout \
  -H "Authorization: Bearer {your_token_here}"
```

### Revoke Specific Token

**POST** `/api/v1/revoke-token`

Revoke a specific token by ID.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Request Body:**
```json
{
  "token_id": "1"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Token revoked successfully",
  "data": null
}
```

**cURL Example:**
```bash
curl -X POST https://yourdomain.com/api/v1/revoke-token \
  -H "Authorization: Bearer {your_token_here}" \
  -H "Content-Type: application/json" \
  -d '{"token_id": "1"}'
```

## Product Endpoints

### List Products

**GET** `/api/v1/products`

Get paginated list of products with optional filtering and sorting.

**Query Parameters:**
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 15)
- `search` - Search in product name or SKU
- `published` - Filter by published status (true/false)
- `product_type` - Filter by product type (simple/variable)
- `sort_by` - Sort field (default: created_at)
- `sort_direction` - Sort direction (asc/desc, default: desc)

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "Products retrieved successfully",
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "product_name": "Sample Product",
        "slug": "sample-product",
        "sku": "SP001",
        "sale_price": "29.99",
        "compare_price": "39.99",
        "quantity": 100,
        "published": true,
        "categories": [],
        "tags": [],
        "suppliers": []
      }
    ],
    "total": 1,
    "per_page": 15
  }
}
```

**cURL Example:**
```bash
curl -X GET "https://yourdomain.com/api/v1/products?page=1&per_page=10&published=true" \
  -H "Authorization: Bearer {your_token_here}"
```

### Get Product

**GET** `/api/v1/products/{id}`

Get detailed information about a specific product.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "Product retrieved successfully",
  "data": {
    "id": 1,
    "product_name": "Sample Product",
    "slug": "sample-product",
    "sku": "SP001",
    "sale_price": "29.99",
    "compare_price": "39.99",
    "quantity": 100,
    "published": true,
    "categories": [],
    "tags": [],
    "suppliers": [],
    "variants": [],
    "product_attributes": []
  }
}
```

**cURL Example:**
```bash
curl -X GET https://yourdomain.com/api/v1/products/1 \
  -H "Authorization: Bearer {your_token_here}"
```

### Create Product

**POST** `/api/v1/products`

Create a new product.

**Headers:**
```
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

**Request Body:**
```json
{
  "product_name": "New Product",
  "slug": "new-product",
  "sku": "NP001",
  "sale_price": 49.99,
  "compare_price": 59.99,
  "quantity": 50,
  "short_description": "A great new product",
  "product_description": "Detailed description of the new product",
  "published": true,
  "disable_out_of_stock": false,
  "categories": [1, 2],
  "tags": [1],
  "suppliers": [1]
}
```

**Response:**
```json
{
  "success": true,
  "message": "Product created successfully",
  "data": {
    "id": 2,
    "product_name": "New Product",
    "slug": "new-product",
    "sku": "NP001",
    "sale_price": "49.99",
    "compare_price": "59.99",
    "quantity": 50,
    "published": true
  }
}
```

**cURL Example:**
```bash
curl -X POST https://yourdomain.com/api/v1/products \
  -H "Authorization: Bearer {your_token_here}" \
  -H "Content-Type: application/json" \
  -d '{
    "product_name": "New Product",
    "slug": "new-product",
    "sku": "NP001",
    "sale_price": 49.99,
    "compare_price": 59.99,
    "quantity": 50,
    "short_description": "A great new product",
    "product_description": "Detailed description of the new product",
    "published": true,
    "disable_out_of_stock": false,
    "categories": [1, 2],
    "tags": [1],
    "suppliers": [1]
  }'
```

### Update Product

**PUT** `/api/v1/products/{id}`

Update an existing product.

**Headers:**
```
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

**Request Body:**
```json
{
  "product_name": "Updated Product Name",
  "sale_price": 44.99,
  "published": false
}
```

**Response:**
```json
{
  "success": true,
  "message": "Product updated successfully",
  "data": {
    "id": 1,
    "product_name": "Updated Product Name",
    "sale_price": "44.99",
    "published": false
  }
}
```

**cURL Example:**
```bash
curl -X PUT https://yourdomain.com/api/v1/products/1 \
  -H "Authorization: Bearer {your_token_here}" \
  -H "Content-Type: application/json" \
  -d '{
    "product_name": "Updated Product Name",
    "sale_price": 44.99,
    "published": false
  }'
```

### Delete Product

**DELETE** `/api/v1/products/{id}`

Delete a product.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "Product deleted successfully",
  "data": null
}
```

**cURL Example:**
```bash
curl -X DELETE https://yourdomain.com/api/v1/products/1 \
  -H "Authorization: Bearer {your_token_here}"
```

## Category Endpoints

### List Categories

**GET** `/api/v1/categories`

Get paginated list of categories.

**Query Parameters:**
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 15)
- `search` - Search in category name
- `published` - Filter by published status (true/false)
- `parent_id` - Filter by parent category (use 'null' for root categories)
- `sort_by` - Sort field (default: sort_order)
- `sort_direction` - Sort direction (asc/desc, default: asc)

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
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
        "published": true,
        "parent_id": null,
        "children": []
      }
    ],
    "total": 1,
    "per_page": 15
  }
}
```

**cURL Example:**
```bash
curl -X GET "https://yourdomain.com/api/v1/categories?published=true&parent_id=null" \
  -H "Authorization: Bearer {your_token_here}"
```

### Get Category

**GET** `/api/v1/categories/{id}`

Get detailed information about a specific category.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "Category retrieved successfully",
  "data": {
    "id": 1,
    "category_name": "Electronics",
    "slug": "electronics",
    "description": "Electronic devices and accessories",
    "published": true,
    "parent": null,
    "children": [],
    "products": []
  }
}
```

**cURL Example:**
```bash
curl -X GET https://yourdomain.com/api/v1/categories/1 \
  -H "Authorization: Bearer {your_token_here}"
```

### Create Category

**POST** `/api/v1/categories`

Create a new category.

**Headers:**
```
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

**Request Body:**
```json
{
  "category_name": "Smartphones",
  "slug": "smartphones",
  "description": "Mobile phones and smartphones",
  "published": true,
  "parent_id": 1,
  "sort_order": 1
}
```

**Response:**
```json
{
  "success": true,
  "message": "Category created successfully",
  "data": {
    "id": 2,
    "category_name": "Smartphones",
    "slug": "smartphones",
    "description": "Mobile phones and smartphones",
    "published": true,
    "parent_id": 1
  }
}
```

**cURL Example:**
```bash
curl -X POST https://yourdomain.com/api/v1/categories \
  -H "Authorization: Bearer {your_token_here}" \
  -H "Content-Type: application/json" \
  -d '{
    "category_name": "Smartphones",
    "slug": "smartphones",
    "description": "Mobile phones and smartphones",
    "published": true,
    "parent_id": 1,
    "sort_order": 1
  }'
```

### Update Category

**PUT** `/api/v1/categories/{id}`

Update an existing category.

**Headers:**
```
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

**Request Body:**
```json
{
  "category_name": "Updated Category Name",
  "published": false
}
```

**Response:**
```json
{
  "success": true,
  "message": "Category updated successfully",
  "data": {
    "id": 1,
    "category_name": "Updated Category Name",
    "published": false
  }
}
```

**cURL Example:**
```bash
curl -X PUT https://yourdomain.com/api/v1/categories/1 \
  -H "Authorization: Bearer {your_token_here}" \
  -H "Content-Type: application/json" \
  -d '{
    "category_name": "Updated Category Name",
    "published": false
  }'
```

### Delete Category

**DELETE** `/api/v1/categories/{id}`

Delete a category.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "Category deleted successfully",
  "data": null
}
```

**cURL Example:**
```bash
curl -X DELETE https://yourdomain.com/api/v1/categories/1 \
  -H "Authorization: Bearer {your_token_here}"
```

## Order Endpoints

### List Orders

**GET** `/api/v1/orders`

Get paginated list of orders.

**Query Parameters:**
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 15)
- `search` - Search in order number
- `order_status_id` - Filter by order status
- `customer_id` - Filter by customer
- `payment_status` - Filter by payment status
- `sort_by` - Sort field (default: created_at)
- `sort_direction` - Sort direction (asc/desc, default: desc)

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
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
        "total_amount": "99.99",
        "customer": {
          "id": 1,
          "first_name": "John",
          "last_name": "Doe"
        },
        "order_status": {
          "id": 1,
          "name": "Pending"
        }
      }
    ],
    "total": 1,
    "per_page": 15
  }
}
```

**cURL Example:**
```bash
curl -X GET "https://yourdomain.com/api/v1/orders?order_status_id=1&payment_status=pending" \
  -H "Authorization: Bearer {your_token_here}"
```

### Get Order

**GET** `/api/v1/orders/{id}`

Get detailed information about a specific order.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "Order retrieved successfully",
  "data": {
    "id": 1,
    "order_number": "ORD-001",
    "customer_id": 1,
    "order_status_id": 1,
    "total_amount": "99.99",
    "customer": {
      "id": 1,
      "first_name": "John",
      "last_name": "Doe"
    },
    "order_status": {
      "id": 1,
      "name": "Pending"
    },
    "order_items": [
      {
        "id": 1,
        "product_id": 1,
        "quantity": 2,
        "price": "49.99",
        "product": {
          "id": 1,
          "product_name": "Sample Product"
        }
      }
    ]
  }
}
```

**cURL Example:**
```bash
curl -X GET https://yourdomain.com/api/v1/orders/1 \
  -H "Authorization: Bearer {your_token_here}"
```

### Create Order

**POST** `/api/v1/orders`

Create a new order.

**Headers:**
```
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

**Request Body:**
```json
{
  "order_number": "ORD-002",
  "customer_id": 1,
  "order_status_id": 1,
  "total_amount": 149.98,
  "tax_amount": 14.99,
  "shipping_amount": 9.99,
  "notes": "Customer requested express shipping"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "id": 2,
    "order_number": "ORD-002",
    "customer_id": 1,
    "order_status_id": 1,
    "total_amount": "149.98"
  }
}
```

**cURL Example:**
```bash
curl -X POST https://yourdomain.com/api/v1/orders \
  -H "Authorization: Bearer {your_token_here}" \
  -H "Content-Type: application/json" \
  -d '{
    "order_number": "ORD-002",
    "customer_id": 1,
    "order_status_id": 1,
    "total_amount": 149.98,
    "tax_amount": 14.99,
    "shipping_amount": 9.99,
    "notes": "Customer requested express shipping"
  }'
```

### Update Order

**PUT** `/api/v1/orders/{id}`

Update an existing order.

**Headers:**
```
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

**Request Body:**
```json
{
  "order_status_id": 2,
  "notes": "Order has been processed"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Order updated successfully",
  "data": {
    "id": 1,
    "order_status_id": 2,
    "notes": "Order has been processed"
  }
}
```

**cURL Example:**
```bash
curl -X PUT https://yourdomain.com/api/v1/orders/1 \
  -H "Authorization: Bearer {your_token_here}" \
  -H "Content-Type: application/json" \
  -d '{
    "order_status_id": 2,
    "notes": "Order has been processed"
  }'
```

### Delete Order

**DELETE** `/api/v1/orders/{id}`

Delete an order.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "Order deleted successfully",
  "data": null
}
```

**cURL Example:**
```bash
curl -X DELETE https://yourdomain.com/api/v1/orders/1 \
  -H "Authorization: Bearer {your_token_here}"
```

## Customer Endpoints

### List Customers

**GET** `/api/v1/customers`

Get paginated list of customers.

**Query Parameters:**
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 15)
- `search` - Search in name, email, or company
- `status` - Filter by customer status
- `sort_by` - Sort field (default: created_at)
- `sort_direction` - Sort direction (asc/desc, default: desc)

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "Customers retrieved successfully",
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "first_name": "John",
        "last_name": "Doe",
        "email": "john@example.com",
        "phone": "+1234567890",
        "company": "ACME Corp",
        "status": "active"
      }
    ],
    "total": 1,
    "per_page": 15
  }
}
```

**cURL Example:**
```bash
curl -X GET "https://yourdomain.com/api/v1/customers?status=active&search=john" \
  -H "Authorization: Bearer {your_token_here}"
```

### Get Customer

**GET** `/api/v1/customers/{id}`

Get detailed information about a specific customer.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "Customer retrieved successfully",
  "data": {
    "id": 1,
    "first_name": "John",
    "last_name": "Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "company": "ACME Corp",
    "status": "active",
    "addresses": [],
    "orders": []
  }
}
```

**cURL Example:**
```bash
curl -X GET https://yourdomain.com/api/v1/customers/1 \
  -H "Authorization: Bearer {your_token_here}"
```

### Create Customer

**POST** `/api/v1/customers`

Create a new customer.

**Headers:**
```
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

**Request Body:**
```json
{
  "first_name": "Jane",
  "last_name": "Smith",
  "email": "jane@example.com",
  "phone": "+1987654321",
  "company": "Tech Solutions",
  "status": "active"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Customer created successfully",
  "data": {
    "id": 2,
    "first_name": "Jane",
    "last_name": "Smith",
    "email": "jane@example.com",
    "phone": "+1987654321",
    "company": "Tech Solutions",
    "status": "active"
  }
}
```

**cURL Example:**
```bash
curl -X POST https://yourdomain.com/api/v1/customers \
  -H "Authorization: Bearer {your_token_here}" \
  -H "Content-Type: application/json" \
  -d '{
    "first_name": "Jane",
    "last_name": "Smith",
    "email": "jane@example.com",
    "phone": "+1987654321",
    "company": "Tech Solutions",
    "status": "active"
  }'
```

### Update Customer

**PUT** `/api/v1/customers/{id}`

Update an existing customer.

**Headers:**
```
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

**Request Body:**
```json
{
  "phone": "+1122334455",
  "status": "inactive"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Customer updated successfully",
  "data": {
    "id": 1,
    "phone": "+1122334455",
    "status": "inactive"
  }
}
```

**cURL Example:**
```bash
curl -X PUT https://yourdomain.com/api/v1/customers/1 \
  -H "Authorization: Bearer {your_token_here}" \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "+1122334455",
    "status": "inactive"
  }'
```

### Delete Customer

**DELETE** `/api/v1/customers/{id}`

Delete a customer.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "Customer deleted successfully",
  "data": null
}
```

**cURL Example:**
```bash
curl -X DELETE https://yourdomain.com/api/v1/customers/1 \
  -H "Authorization: Bearer {your_token_here}"
```

## User Management Endpoints

### List Users

**GET** `/api/v1/users`

Get paginated list of users.

**Query Parameters:**
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 15)
- `search` - Search in name or email
- `sort_by` - Sort field (default: created_at)
- `sort_direction` - Sort direction (asc/desc, default: desc)

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
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
        "roles": [],
        "permissions": []
      }
    ],
    "total": 1,
    "per_page": 15
  }
}
```

**cURL Example:**
```bash
curl -X GET "https://yourdomain.com/api/v1/users?search=john" \
  -H "Authorization: Bearer {your_token_here}"
```

### Get User

**GET** `/api/v1/users/{id}`

Get detailed information about a specific user.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "User retrieved successfully",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "roles": [],
    "permissions": []
  }
}
```

**cURL Example:**
```bash
curl -X GET https://yourdomain.com/api/v1/users/1 \
  -H "Authorization: Bearer {your_token_here}"
```

### Create User

**POST** `/api/v1/users`

Create a new user.

**Headers:**
```
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

**Request Body:**
```json
{
  "name": "Jane Smith",
  "email": "jane@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "roles": ["admin"]
}
```

**Response:**
```json
{
  "success": true,
  "message": "User created successfully",
  "data": {
    "id": 2,
    "name": "Jane Smith",
    "email": "jane@example.com",
    "roles": ["admin"],
    "permissions": []
  }
}
```

**cURL Example:**
```bash
curl -X POST https://yourdomain.com/api/v1/users \
  -H "Authorization: Bearer {your_token_here}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Smith",
    "email": "jane@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "roles": ["admin"]
  }'
```

### Update User

**PUT** `/api/v1/users/{id}`

Update an existing user.

**Headers:**
```
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

**Request Body:**
```json
{
  "name": "Updated Name",
  "roles": ["editor", "viewer"]
}
```

**Response:**
```json
{
  "success": true,
  "message": "User updated successfully",
  "data": {
    "id": 1,
    "name": "Updated Name",
    "roles": ["editor", "viewer"]
  }
}
```

**cURL Example:**
```bash
curl -X PUT https://yourdomain.com/api/v1/users/1 \
  -H "Authorization: Bearer {your_token_here}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Updated Name",
    "roles": ["editor", "viewer"]
  }'
```

### Delete User

**DELETE** `/api/v1/users/{id}`

Delete a user.

**Headers:**
```
Authorization: Bearer {your_token_here}
```

**Response:**
```json
{
  "success": true,
  "message": "User deleted successfully",
  "data": null
}
```

**cURL Example:**
```bash
curl -X DELETE https://yourdomain.com/api/v1/users/1 \
  -H "Authorization: Bearer {your_token_here}"
```

## Additional Endpoints

The API also provides full CRUD operations for the following entities:

- **Tags** - `/api/v1/tags`
- **Suppliers** - `/api/v1/suppliers`
- **Attributes** - `/api/v1/attributes`
- **Variants** - `/api/v1/variants`
- **Coupons** - `/api/v1/coupons`
- **Slideshows** - `/api/v1/slideshows`
- **Cards** - `/api/v1/cards`
- **Countries** - `/api/v1/countries`
- **Shipping Zones** - `/api/v1/shipping-zones`
- **Shipping Rates** - `/api/v1/shipping-rates`

Each endpoint follows the same pattern:
- `GET /api/v1/{resource}` - List resources
- `GET /api/v1/{resource}/{id}` - Get specific resource
- `POST /api/v1/{resource}` - Create resource
- `PUT /api/v1/{resource}/{id}` - Update resource
- `DELETE /api/v1/{resource}/{id}` - Delete resource

## Error Handling

The API returns appropriate HTTP status codes and error messages:

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

When validation fails, the API returns a 422 status with detailed error information:

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

The API implements rate limiting to prevent abuse. Limits are applied per IP address and user token.

## Pagination

All list endpoints support pagination with the following query parameters:
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 15, max: 100)

## Filtering and Sorting

Most endpoints support filtering and sorting:

- **Filtering** - Use query parameters to filter results
- **Sorting** - Use `sort_by` and `sort_direction` parameters
- **Search** - Use `search` parameter for text-based searches

## Relationships

The API automatically loads related data when requested. Use the `with` parameter to specify which relationships to include:

```
GET /api/v1/products?with=categories,tags,suppliers
```

## Security

- All endpoints (except register/login) require authentication
- Tokens are automatically expired on logout
- Passwords are hashed using Laravel's built-in hashing
- Input validation is enforced on all endpoints
- SQL injection protection through Eloquent ORM
- XSS protection through proper output encoding

## Testing

You can test the API using tools like:
- cURL (examples provided above)
- Postman
- Insomnia
- Any HTTP client

## Support

For API support or questions, please contact the development team or refer to the Laravel documentation for additional information about the framework.
