<?php

namespace App\Services;

use App\Models\User;
use App\Models\Position;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Exceptions\UserAlreadyExistsException;

class UserService
{
    public function createUser($validatedData, Request $request)
    {
        $existingUser = User::where('email', $validatedData['email'])
            ->orWhere('phone', $validatedData['phone'])
            ->first();

        if ($existingUser) {
            throw new UserAlreadyExistsException('User already exists with this email');
        }

        $validatedData['position'] = Position::find($validatedData['position_id'])->name;
        $validatedData['registration_timestamp'] = now();

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('public/photos');
        }

        return User::create($validatedData);
    }

    public function getUsers($request)
    {
        $count = $request->input('count', 10);
        $page = $request->input('page', 1);

        return User::orderBy('registration_timestamp', 'desc')->paginate($count, ['*'], 'page', $page);
    }
}
