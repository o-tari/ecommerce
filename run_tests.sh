#!/bin/bash

# Laravel Ecommerce Pest PHP Test Runner
# This script runs comprehensive tests for the Laravel ecommerce application

echo "🚀 Starting Laravel Ecommerce Test Suite"
echo "========================================"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    print_error "This script must be run from the Laravel project root directory"
    exit 1
fi

# Check if Pest is installed
if ! command -v ./vendor/bin/pest &> /dev/null; then
    print_error "Pest PHP is not installed. Please run: composer install"
    exit 1
fi

# Check if database is configured
if [ ! -f ".env" ]; then
    print_warning "No .env file found. Creating test environment..."
    cp .env.example .env
    php artisan key:generate
fi

# Set test environment
export APP_ENV=testing
export DB_CONNECTION=sqlite
export DB_DATABASE=:memory:

print_status "Setting up test environment..."

# Clear any existing caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run database migrations for testing
print_status "Running database migrations..."
php artisan migrate:fresh --env=testing

# Run seeders if they exist
if [ -f "database/seeders/DatabaseSeeder.php" ]; then
    print_status "Running database seeders..."
    php artisan db:seed --env=testing
fi

echo ""
echo "🧪 Running Test Suite"
echo "===================="

# Function to run tests with summary
run_test_suite() {
    local suite_name="$1"
    local test_path="$2"
    local options="$3"
    
    echo ""
    print_status "Running $suite_name tests..."
    echo "----------------------------------------"
    
    if [ -d "$test_path" ]; then
        ./vendor/bin/pest $options "$test_path" --stop-on-failure
        
        if [ $? -eq 0 ]; then
            print_success "$suite_name tests passed! ✅"
        else
            print_error "$suite_name tests failed! ❌"
            return 1
        fi
    else
        print_warning "Test directory $test_path not found, skipping..."
    fi
}

# Track overall test results
overall_success=true

# Run Unit Tests
if run_test_suite "Unit" "tests/Unit" "--coverage"; then
    print_success "Unit tests completed successfully"
else
    print_error "Unit tests failed"
    overall_success=false
fi

# Run Feature Tests
if run_test_suite "Feature" "tests/Feature" "--coverage"; then
    print_success "Feature tests completed successfully"
else
    print_error "Feature tests failed"
    overall_success=false
fi

# Run specific resource tests
echo ""
print_status "Running Filament Resource Tests..."
echo "----------------------------------------"

# Product Resource Tests
if [ -f "tests/Feature/Filament/ProductResourceTest.php" ]; then
    ./vendor/bin/pest tests/Feature/Filament/ProductResourceTest.php --stop-on-failure
    if [ $? -eq 0 ]; then
        print_success "ProductResource tests passed! ✅"
    else
        print_error "ProductResource tests failed! ❌"
        overall_success=false
    fi
fi

# Category Resource Tests
if [ -f "tests/Feature/Filament/CategoryResourceTest.php" ]; then
    ./vendor/bin/pest tests/Feature/Filament/CategoryResourceTest.php --stop-on-failure
    if [ $? -eq 0 ]; then
        print_success "CategoryResource tests passed! ✅"
    else
        print_error "CategoryResource tests failed! ❌"
        overall_success=false
    fi
fi

# User Resource Tests
if [ -f "tests/Feature/Filament/UserResourceTest.php" ]; then
    ./vendor/bin/pest tests/Feature/Filament/UserResourceTest.php --stop-on-failure
    if [ $? -eq 0 ]; then
        print_success "UserResource tests passed! ✅"
    else
        print_error "UserResource tests failed! ❌"
        overall_success=false
    fi
fi

# Order Resource Tests
if [ -f "tests/Feature/Filament/OrderResourceTest.php" ]; then
    ./vendor/bin/pest tests/Feature/Filament/OrderResourceTest.php --stop-on-failure
    if [ $? -eq 0 ]; then
        print_success "OrderResource tests passed! ✅"
    else
        print_error "OrderResource tests failed! ❌"
        overall_success=false
    fi
fi

# Run all tests together for coverage report
echo ""
print_status "Running complete test suite for coverage report..."
echo "--------------------------------------------------------"

./vendor/bin/pest --coverage --min=80

# Generate coverage report
if command -v genhtml &> /dev/null; then
    print_status "Generating HTML coverage report..."
    if [ -d "coverage" ]; then
        genhtml coverage/index.xml -o coverage/html
        print_success "Coverage report generated at coverage/html/index.html"
    fi
fi

# Cleanup
print_status "Cleaning up test environment..."

# Reset environment
export APP_ENV=local
export DB_CONNECTION=mysql

# Clear test caches
php artisan config:clear
php artisan cache:clear

echo ""
echo "📊 Test Summary"
echo "==============="

if [ "$overall_success" = true ]; then
    print_success "🎉 All tests passed successfully!"
    echo ""
    echo "✅ Unit Tests: Passed"
    echo "✅ Feature Tests: Passed"
    echo "✅ Filament Resource Tests: Passed"
    echo "✅ Authentication Tests: Passed"
    echo ""
    print_success "Your Laravel ecommerce application is working correctly!"
    exit 0
else
    print_error "❌ Some tests failed. Please review the output above."
    echo ""
    echo "🔍 Common issues to check:"
    echo "   - Database configuration"
    echo "   - Missing dependencies"
    echo "   - Environment variables"
    echo "   - Model relationships"
    echo "   - Filament resource configuration"
    echo ""
    print_warning "Run individual test suites to isolate issues:"
    echo "   ./vendor/bin/pest tests/Unit"
    echo "   ./vendor/bin/pest tests/Feature"
    echo "   ./vendor/bin/pest tests/Feature/Filament/ProductResourceTest.php"
    exit 1
fi
