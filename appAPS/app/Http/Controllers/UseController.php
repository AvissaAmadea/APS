<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;

class UseController extends Controller
{
    public function assignRole(Request $request, $userId)
    {
        // Check if the authenticated user is an admin
        if (auth()->user()->role !== 'superadmin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate request input
        $validatedData = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        // Find the user by ID
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Change the role only if the authenticated user is an admin
        $user->role_id = $validatedData['role_id'];
        $user->save();

        return response()->json(['message' => 'Role assigned successfully']);
    }
}
