<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Create a test user with admin permissions
 */
function createAdminUser(): \App\Models\User
{
    $user = \App\Models\User::factory()->create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
    ]);

    // Assign admin role if using Spatie permissions
    if (class_exists(\Spatie\Permission\Models\Role::class)) {
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Store Administrator']);
        $user->assignRole($adminRole);
    }

    return $user;
}

/**
 * Create a test user without admin permissions
 */
function createRegularUser(): \App\Models\User
{
    return \App\Models\User::factory()->create([
        'name' => 'Regular User',
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
    ]);
}

/**
 * Authenticate as admin user
 */
function actingAsAdmin(): \App\Models\User
{
    // Try to find the seeded admin user first
    $user = \App\Models\User::where('email', 'admin@example.com')->first();
    
    // If not found, create one
    if (!$user) {
        $user = createAdminUser();
    }
    
    test()->actingAs($user);
    return $user;
}

/**
 * Authenticate as regular user
 */
function actingAsUser(): \App\Models\User
{
    $user = createRegularUser();
    test()->actingAs($user);
    return $user;
}

/**
 * Assert that a model has been soft deleted
 */
function expectModelToBeSoftDeleted(string $modelClass, int $id): void
{
    $model = $modelClass::withTrashed()->find($id);
    expect($model)->not->toBeNull();
    expect($model->trashed())->toBeTrue();
}

/**
 * Assert that a model has been hard deleted
 */
function expectModelToBeHardDeleted(string $modelClass, int $id): void
{
    $model = $modelClass::find($id);
    expect($model)->toBeNull();
}

/**
 * Assert that a model exists in the database
 */
function expectModelToExist(string $modelClass, int $id): void
{
    $model = $modelClass::find($id);
    expect($model)->not->toBeNull();
}
