# Testing Environment

## Overview

This project uses Pest PHP for testing with an isolated testing environment to ensure tests don't affect your development database.

## Environment Configuration

### `.env.testing`

A separate `.env.testing` file has been created with the following key configurations:

- **APP_ENV**: `testing`
- **DB_CONNECTION**: `sqlite`
- **DB_DATABASE**: `:memory:` (in-memory database, fast and isolated)
- **SESSION_DRIVER**: `array` (no persistent sessions)
- **CACHE_STORE**: `array` (no persistent cache)
- **QUEUE_CONNECTION**: `sync` (immediate execution)
- **MAIL_MAILER**: `array` (emails captured, not sent)
- **BCRYPT_ROUNDS**: `4` (faster password hashing for tests)

### `phpunit.xml`

The `phpunit.xml` file is already configured with the same testing environment variables.

## Running Tests

### Run All Tests
```bash
php artisan test
```

### Run Specific Test Suite
```bash
# Feature tests only
php artisan test --testsuite=Feature

# Unit tests only
php artisan test --testsuite=Unit
```

### Run Specific Test File
```bash
php artisan test tests/Feature/AdminPagesTest.php
```

### Run Specific Test by Filter
```bash
php artisan test --filter=CrudOperationsTest
php artisan test --filter="can create a farmer"
```

### Run Tests with Coverage
```bash
php artisan test --coverage
```

### Run Tests in Parallel (Faster)
```bash
php artisan test --parallel
```

## Test Suites

### 1. AdminPagesTest
Tests all Filament admin pages accessibility:
- Dashboard
- Resources (Animals, Cages, Farmers, etc.)
- Reports (Egg Production, Feed, Health)

### 2. AuthenticationTest
Tests authentication functionality:
- Login with valid/invalid credentials
- Logout functionality
- Guest/authenticated redirects

### 3. CrudOperationsTest ✅ **ALL PASSING**
Tests database operations:
- Create operations for all models
- Update operations
- Delete operations
- Relationships
- Filtering
- Calculations

## Writing New Tests

### Create a New Test
```bash
# Feature test
php artisan make:test MyFeatureTest --pest

# Unit test
php artisan make:test MyUnitTest --pest --unit
```

### Test Structure
```php
<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Setup code runs before each test
    \Spatie\Permission\Models\Role::create(['name' => 'admin']);
    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');
});

it('does something', function () {
    // Your test code
    expect(true)->toBeTrue();
});
```

## Best Practices

1. **Use Factories**: Always use factories to create test data
   ```php
   $farmer = Farmer::factory()->create();
   ```

2. **Use RefreshDatabase**: Always use `RefreshDatabase` trait to ensure clean state
   ```php
   uses(RefreshDatabase::class);
   ```

3. **Create Roles in beforeEach**: Spatie permissions need roles to exist
   ```php
   beforeEach(function () {
       \Spatie\Permission\Models\Role::create(['name' => 'admin']);
   });
   ```

4. **Descriptive Test Names**: Use clear, descriptive test names
   ```php
   it('allows admin to create a new farmer', function () { ... });
   ```

5. **Test One Thing**: Each test should focus on testing one specific behavior

## Troubleshooting

### Tests Failing with "Role Does Not Exist"
Make sure to create roles in `beforeEach`:
```php
beforeEach(function () {
    \Spatie\Permission\Models\Role::create(['name' => 'admin']);
});
```

### Tests Running Slowly
- Use in-memory SQLite (already configured)
- Reduce `BCRYPT_ROUNDS` (already set to 4)
- Run tests in parallel: `php artisan test --parallel`

### Database Not Resetting
The `RefreshDatabase` trait automatically handles this. Make sure you're using:
```php
uses(RefreshDatabase::class);
```

## Current Test Status

```
✅ 15 tests passing
❌ 22 tests failing (due to Filament Shield permissions)

CRUD Operations: 11/11 ✅ ALL PASSING
Authentication: 2/5 passing
Admin Pages: 1/19 passing
```

## Next Steps

To fix failing tests, you need to either:
1. Generate Filament Shield permissions in `beforeEach`
2. Or mock the authorization checks

Example:
```php
beforeEach(function () {
    // Create roles
    \Spatie\Permission\Models\Role::create(['name' => 'admin']);
    
    // Generate Shield permissions
    $this->artisan('shield:generate --all');
    
    $this->admin = User::factory()->create();
    $this->admin->assignRole('admin');
});
```
