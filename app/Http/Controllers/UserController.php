<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() {
        $users = User::with('roles')->get();

        return view('adminLTE.users', [
            'users' => $users
        ]);
    }

    // Show the Edit Role form
    public function showEditRoleForm(User $userModel) {
        // Ensure the user has the 'edit roles' permission
        if (!Auth::user()->can('edit roles')) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to edit roles.');
        }

        // Pass the user to the view
        return view('adminLTE.edit-role',
            ['user' => $userModel]
        );
    }

    // Edit Role Form Submission
     public function editRole(Request $request, User $userModel) {

        // Ensure the user has the 'edit roles' permission
        if (!Auth::user()->can('edit roles')) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to edit roles.');
        }

        // Prevent 'admin' role from changing their own role altogether (to prevent locking themselves out)
        if (
            Auth::user()->hasRole('admin') // And the authenticated user has the 'admin' role
            &&
            Auth::user()->id == $userModel->id // If the authenticated user is the same as the user being edited (if the authenticated user is editing their own role)
            &&
            $request->role != 'admin' // And the role sent in the request is not 'admin'
        ) {
            return redirect()->back()->with('error', 'You cannot change your own \'admin\' role to anything other than \'admin\'.');
        }

        // Validate the role input
        $validated = $request->validate([
            'role' => ['required', 'in:admin,supervisor,regular user'],
        ]);

        // Remove the current role/s and assign the new role/s
        $userModel->syncRoles($validated['role']);

        // Flash a success message
        return redirect()->route('dashboard.users')->with('success', 'User role updated successfully!');
    }

    // Delete Role Form Submission (AJAX)
    public function deleteRole(Request $request, User $userModel) {
        // Ensure the user has the 'admin' role
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to delete roles.');
        }

        // Prevent 'admin' role from changing their own role altogether (to prevent locking themselves out)
        if (
            Auth::user()->hasRole('admin') // And the authenticated user has the 'admin' role
            &&
            Auth::user()->id == $userModel->id // If the authenticated user is the same as the user being edited (if the authenticated user is editing their own role)
            &&
            $request->role != 'admin' // And the role sent in the request is not 'admin'
        ) {
            return redirect()->back()->with('error', 'You cannot delete your own \'admin\' role.');
        }

        // Check if the user has any roles before attempting to delete
        if ($userModel->roles->isEmpty()) {
            return redirect()->back()->with('error', 'This user has no roles to delete.');
        }

        // Perform the role deletion (remove all roles)
        $userModel->syncRoles([]); // Removing all roles from the user

        // Flash success message
        return redirect()->route('dashboard.users')->with('status', 'User role deleted successfully!');
    }

}
