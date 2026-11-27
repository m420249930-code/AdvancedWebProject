<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // عرض المستخدمين
    public function index()
    {
        $users = User::latest()->get();

        return view('users', compact('users'));
    }

    // إضافة مستخدم
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create($validated);

        return redirect('/users')
            ->with('success', 'User added successfully!');
    }

    // حذف مستخدم باستخدام Eloquent
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/users')
            ->with('success', 'User deleted successfully!');
    }

    // فتح فورم التعديل
    public function edit($id)
    {
        $editingUser = User::findOrFail($id);

        $users = User::latest()->get();

        return view('users', compact('users', 'editingUser'));
    }

    // تحديث المستخدم باستخدام Eloquent
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($request->id),
            ],
            'password' => 'nullable|string|min:8',
        ]);

        $user = User::findOrFail($validated['id']);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);

        return redirect('/users')
            ->with('success', 'User updated successfully!');
    }
}
