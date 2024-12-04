<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ApiResponserTrait;

class UserController extends Controller
{
    use ApiResponserTrait;

    public function index()
    {
        $users = User::all();
        return $this->successResponse($users, 'All Users');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return $this->successResponse($user, 'User Created');
    }

    public function update(Request $request, $id)
    {

        $user = User::find($id);
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }
       
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        $user->save();

        return $this->successResponse($user, 'User Updated');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        $user->delete();
        return $this->successResponse($user, 'User deleted');
    }
}
