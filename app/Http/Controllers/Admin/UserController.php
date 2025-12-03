<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // show paginated list of users
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function ($s) use ($q) {
                $s->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        // role filter (e.g. ?role=admin or ?role=user)
        $role = null;
        if ($request->filled('role')) {
            $roleValue = $request->get('role');
            if (in_array($roleValue, ['user', 'admin'])) {
                $role = $roleValue;
                $query->where('role', $role);
            }
        }

        $users = $query->orderBy('id', 'desc')->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users', 'role'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'nullable|in:user,admin',
            'status' => 'nullable|in:active,locked',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // If password provided, hash it; otherwise remove it from data to avoid overwriting
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // prevent deleting self
        if (Auth::check() && Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'Không thể xóa chính bạn');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa');
    }

    // show trashed users
    public function trashed(Request $request)
    {
        $query = User::onlyTrashed();

        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function ($s) use ($q) {
                $s->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $users = $query->orderBy('deleted_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.users.trashed', compact('users'));
    }

    // restore soft deleted user
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        // prevent restoring self if needed
        $user->restore();
        return redirect()->route('admin.users.trashed')->with('success', 'Người dùng đã được khôi phục');
    }

    // permanently delete user
    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        // prevent deleting self
        if (Auth::check() && Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'Không thể xóa chính bạn');
        }
        $user->forceDelete();
        return redirect()->route('admin.users.trashed')->with('success', 'Người dùng đã bị xóa vĩnh viễn');
    }
}
