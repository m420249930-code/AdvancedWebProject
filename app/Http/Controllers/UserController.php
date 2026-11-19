<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // عرض المستخدمين
    public function index()
    {
        $users = DB::table('users')->latest()->get();

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

        DB::table('users')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/users')
            ->with('success', 'User added successfully!');
    }

    // حذف مستخدم
    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();

        return redirect('/users')
            ->with('success', 'User deleted successfully!');
    }

    // فتح فورم التعديل
    public function edit($id)
    {
        $editingUser = DB::table('users')
            ->where('id', $id)
            ->first();

        abort_if(!$editingUser, 404);

        $users = DB::table('users')->latest()->get();

        return view('users', compact('users', 'editingUser'));
    }

    // تحديث المستخدم
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

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'updated_at' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        DB::table('users')
            ->where('id', $validated['id'])
            ->update($data);

        return redirect('/users')
            ->with('success', 'User updated successfully!');
    }
}
