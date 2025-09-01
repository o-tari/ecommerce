<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::with(['roles', 'permissions']);

        // Apply filters
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $users = $query->paginate($perPage);

        return $this->successResponse($users, 'Users retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();
        
        // Hash password
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        // Assign roles if provided
        if (isset($data['roles'])) {
            $user->assignRole($data['roles']);
        }

        $user->load(['roles', 'permissions']);

        return $this->successResponse($user, 'User created successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        $user->load(['roles', 'permissions']);

        return $this->successResponse($user, 'User retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        // Sync roles if provided
        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        $user->load(['roles', 'permissions']);

        return $this->successResponse($user, 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return $this->errorResponse('Cannot delete your own account', Response::HTTP_CONFLICT);
        }

        $user->delete();

        return $this->successResponse(null, 'User deleted successfully');
    }
}
