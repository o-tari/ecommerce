<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Allow all actions in test environment
        if (app()->environment('testing')) {
            return true;
        }
        
        return true; // Allow all users to view products list
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        // Allow all actions in test environment
        if (app()->environment('testing')) {
            return true;
        }
        
        return true; // Allow all users to view individual products
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Allow all actions in test environment
        if (app()->environment('testing')) {
            return true;
        }
        
        return true; // Allow all authenticated users to create products
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        // Allow all actions in test environment
        if (app()->environment('testing')) {
            return true;
        }
        
        return true; // Allow all authenticated users to update products
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        // Allow all actions in test environment
        if (app()->environment('testing')) {
            return true;
        }
        
        return true; // Allow all authenticated users to delete products
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        // Allow all actions in test environment
        if (app()->environment('testing')) {
            return true;
        }
        
        return true; // Allow all authenticated users to restore products
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        // Allow all actions in test environment
        if (app()->environment('testing')) {
            return true;
        }
        
        return true; // Allow all authenticated users to permanently delete products
    }
}
