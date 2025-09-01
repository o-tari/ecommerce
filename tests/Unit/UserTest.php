<?php

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->user = User::factory()->unverified()->create();
});

describe('User Model', function () {
    it('can be created with valid attributes', function () {
        expect($this->user)->toBeInstanceOf(User::class);
        expect($this->user->name)->toBeString();
        expect($this->user->email)->toBeString();
        expect($this->user->password)->toBeString();
    });

    it('has correct fillable attributes', function () {
        $fillable = [
            'name',
            'email',
            'password',
        ];

        expect($this->user->getFillable())->toBe($fillable);
    });

    it('has correct hidden attributes', function () {
        $hidden = [
            'password',
            'remember_token',
        ];

        expect($this->user->getHidden())->toBe($hidden);
    });

    it('has correct casts', function () {
        // Test that email_verified_at is properly cast when verified
        $this->user->markEmailAsVerified();
        expect($this->user->email_verified_at)->toBeInstanceOf(\Carbon\Carbon::class);
        
        // Test that password is hashed
        expect($this->user->password)->toBeString();
        expect($this->user->password)->not->toBe('password'); // Should be hashed
    });

    it('can hash password', function () {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        expect(Hash::check('password', $user->password))->toBeTrue();
        expect(Hash::check('wrongpassword', $user->password))->toBeFalse();
    });

    it('can verify email', function () {
        $this->user->markEmailAsVerified();
        expect($this->user->hasVerifiedEmail())->toBeTrue();
    });

    it('can check if email is verified', function () {
        expect($this->user->hasVerifiedEmail())->toBeFalse();
        
        $this->user->markEmailAsVerified();
        expect($this->user->hasVerifiedEmail())->toBeTrue();
    });
});

describe('User Relationships', function () {
    it('can have many created products', function () {
        Product::factory()->create(['created_by' => $this->user->id, 'updated_by' => $this->user->id]);
        Product::factory()->create(['created_by' => $this->user->id, 'updated_by' => $this->user->id]);

        expect($this->user->createdProducts)->toHaveCount(2);
        expect($this->user->createdProducts->first())->toBeInstanceOf(Product::class);
    });

    it('can have many updated products', function () {
        Product::factory()->create(['created_by' => $this->user->id, 'updated_by' => $this->user->id]);
        Product::factory()->create(['created_by' => $this->user->id, 'updated_by' => $this->user->id]);

        expect($this->user->updatedProducts)->toHaveCount(2);
        expect($this->user->updatedProducts->first())->toBeInstanceOf(Product::class);
    });

    it('can have many created categories', function () {
        Category::factory()->create(['created_by' => $this->user->id, 'updated_by' => $this->user->id]);
        Category::factory()->create(['created_by' => $this->user->id, 'updated_by' => $this->user->id]);

        expect($this->user->createdCategories)->toHaveCount(2);
        expect($this->user->createdCategories->first())->toBeInstanceOf(Category::class);
    });

    it('can have many updated categories', function () {
        Category::factory()->create(['created_by' => $this->user->id, 'updated_by' => $this->user->id]);
        Category::factory()->create(['created_by' => $this->user->id, 'updated_by' => $this->user->id]);

        expect($this->user->updatedCategories)->toHaveCount(2);
        expect($this->user->updatedCategories->first())->toBeInstanceOf(Category::class);
    });

    it('can have many created attributes', function () {
        Attribute::factory()->create(['created_by' => $this->user->id, 'updated_by' => $this->user->id]);
        Attribute::factory()->create(['created_by' => $this->user->id, 'updated_by' => $this->user->id]);

        expect($this->user->createdAttributes)->toHaveCount(2);
        expect($this->user->createdAttributes->first())->toBeInstanceOf(Attribute::class);
    });

    it('can have many updated attributes', function () {
        Attribute::factory()->create(['created_by' => $this->user->id, 'updated_by' => $this->user->id]);
        Attribute::factory()->create(['created_by' => $this->user->id, 'updated_by' => $this->user->id]);

        expect($this->user->updatedAttributes)->toHaveCount(2);
        expect($this->user->updatedAttributes->first())->toBeInstanceOf(Attribute::class);
    });
});

describe('User Authentication', function () {
    it('can authenticate with correct credentials', function () {
        $user = User::create([
            'name' => 'Auth User',
            'email' => 'auth@example.com',
            'password' => Hash::make('password'),
        ]);

        expect(auth()->attempt(['email' => 'auth@example.com', 'password' => 'password']))->toBeTrue();
    });

    it('cannot authenticate with incorrect password', function () {
        $user = User::create([
            'name' => 'Auth User',
            'email' => 'auth@example.com',
            'password' => Hash::make('password'),
        ]);

        expect(auth()->attempt(['email' => 'auth@example.com', 'password' => 'wrongpassword']))->toBeFalse();
    });

    it('cannot authenticate with non-existent email', function () {
        expect(auth()->attempt(['email' => 'nonexistent@example.com', 'password' => 'password']))->toBeFalse();
    });
});

describe('User Scopes and Queries', function () {
    it('can search by name', function () {
        User::factory()->create(['name' => 'Special User']);
        User::factory()->create(['name' => 'Regular User']);

        $searchResults = User::where('name', 'like', '%Special%')->get();
        expect($searchResults)->toHaveCount(1);
        expect($searchResults->first()->name)->toBe('Special User');
    });

    it('can search by email', function () {
        User::factory()->create(['email' => 'special@example.com']);
        User::factory()->create(['email' => 'regular@example.com']);

        $searchResults = User::where('email', 'like', '%special%')->get();
        expect($searchResults)->toHaveCount(1);
        expect($searchResults->first()->email)->toBe('special@example.com');
    });

    it('can scope verified users', function () {
        $verifiedUser = User::factory()->create();
        $verifiedUser->markEmailAsVerified();

        $unverifiedUser = User::factory()->create();

        $verifiedUsers = User::whereNotNull('email_verified_at')->get();
        $unverifiedUsers = User::whereNull('email_verified_at')->get();

        expect($verifiedUsers)->toHaveCount(2); // Including the one from beforeEach that was verified
        expect($unverifiedUsers)->toHaveCount(1); // Only the new unverified user
    });
});

describe('User Factory', function () {
    it('can create user with factory', function () {
        $user = User::factory()->create();
        expect($user)->toBeInstanceOf(User::class);
        expect($user->name)->toBeString();
        expect($user->email)->toBeString();
        expect($user->password)->toBeString();
    });

    it('can create multiple users with factory', function () {
        $users = User::factory()->count(3)->create();
        expect($users)->toHaveCount(3);
        
        foreach ($users as $user) {
            expect($user)->toBeInstanceOf(User::class);
        }
    });

    it('can create user with specific attributes', function () {
        $user = User::factory()->create([
            'name' => 'Custom Name',
            'email' => 'custom@example.com',
        ]);

        expect($user->name)->toBe('Custom Name');
        expect($user->email)->toBe('custom@example.com');
    });
});

describe('User Deletion', function () {
    it('can be deleted', function () {
        $userId = $this->user->id;
        $this->user->delete();

        expectModelToBeHardDeleted(User::class, $userId);
    });

    it('cannot be deleted when related products exist', function () {
        $product = Product::factory()->create([
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $productId = $product->id;
        
        // User should not be deleted due to foreign key constraints
        expect(fn() => $this->user->delete())->toThrow(\Illuminate\Database\QueryException::class);
        
        // User should still exist
        expect(User::find($this->user->id))->not->toBeNull();
        
        // Product should still exist with the same references
        expectModelToExist(Product::class, $productId);
        expect(Product::find($productId)->created_by)->toBe($this->user->id);
        expect(Product::find($productId)->updated_by)->toBe($this->user->id);
    });
});
