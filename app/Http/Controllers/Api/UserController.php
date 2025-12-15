<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/users",
     * summary="Get list of users",
     * tags={"Users"},
     * @OA\Parameter(
     * name="status",
     * in="query",
     * description="Filter by status (active/inactive)",
     * required=false,
     * @OA\Schema(type="string")
     * ),
     * @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        return response()->json($query->latest()->paginate(10));
    }

    /**
     * @OA\Post(
     * path="/api/users",
     * summary="Create new user",
     * tags={"Users"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"name","email","phone_number","password","status"},
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", format="email", example="john@test.com"),
     * @OA\Property(property="phone_number", type="string", example="0123456789"),
     * @OA\Property(property="password", type="string", format="password", example="secret123"),
     * @OA\Property(property="status", type="string", example="active")
     * )
     * ),
     * @OA\Response(response=201, description="User created successfully"),
     * @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        return response()->json(['message' => 'User created', 'data' => $user], 201);
    }

    /**
     * @OA\Get(
     * path="/api/users/{id}",
     * summary="Get user details",
     * tags={"Users"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(response=200, description="Success"),
     * @OA\Response(response=404, description="User not found")
     * )
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);
        return response()->json($user);
    }

    /**
     * @OA\Put(
     * path="/api/users/{id}",
     * summary="Update user details",
     * tags={"Users"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="name", type="string", example="Jane Doe"),
     * @OA\Property(property="email", type="string", example="jane@test.com"),
     * @OA\Property(property="phone_number", type="string", example="0987654321"),
     * @OA\Property(property="status", type="string", example="inactive")
     * )
     * ),
     * @OA\Response(response=200, description="User updated"),
     * @OA\Response(response=404, description="User not found")
     * )
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);

        $user->update($request->validated());
        return response()->json(['message' => 'User updated', 'data' => $user]);
    }

    /**
     * @OA\Delete(
     * path="/api/users/{id}",
     * summary="Delete a user",
     * tags={"Users"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(response=200, description="User deleted")
     * )
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    /**
     * @OA\Post(
     * path="/api/users/bulk-delete",
     * summary="Bulk delete users",
     * tags={"Users"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"ids"},
     * @OA\Property(property="ids", type="array", @OA\Items(type="integer", example=1))
     * )
     * ),
     * @OA\Response(response=200, description="Users deleted")
     * )
     */
    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        User::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Users deleted successfully']);
    }
}