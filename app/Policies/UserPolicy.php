<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
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
        
        return true; // Allow all users to view users list
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Allow all actions in test environment
        if (app()->environment('testing')) {
            return true;
        }
        
        return true; // Allow all users to view individual users
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
        
        return true; // Allow all authenticated users to create users
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Allow all actions in test environment
        if (app()->environment('testing')) {
            return true;
        }
        
        return true; // Allow all authenticated users to update users
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Allow all actions in test environment
        if (app()->environment('testing')) {
            return true;
        }
        
        return true; // Allow all authenticated users to delete users
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        // Allow all actions in test environment
        if (app()->environment('testing')) {
            return true;
        }
        
        return true; // Allow all authenticated users to restore users
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        // Allow all actions in test environment
        if (app()->environment('testing')) {
            return true;
        }
        
        return true; // Allow all authenticated users to permanently delete users
    }
}
