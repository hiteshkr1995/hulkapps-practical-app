<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function changePassword(Request $request)
    {
        return view('auth.passwords.change');
    }

    public function changePasswordUpdate(ChangePasswordUpdateRequest $request)
    {
        $user = auth()->user();

        // Check for old password
        if (Hash::check($request->old_password, $user->password)) { 

            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();

            return redirect()->route('welcome')->with('status', 'Password change sucessfully!');

        } else {

            // throw a validation error/exception for old password
            throw ValidationException::withMessages(['old_password' => 'Old Password not match in our record.']);

        }
    }
}
