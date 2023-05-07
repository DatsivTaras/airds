<?php

namespace App\Http\Controllers;

use App\Classes\Enum\UserStatus;
use App\Http\Requests\PasswordRequest;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', auth()->id())->first();

        return view('profile', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('profile/edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->fill($request->all());
        $user->save();

        return redirect('/profile');
    }


    public function destroy(Request $request)
    {
        $user = User::find(auth()->id());
        $user->status = UserStatus::DELETED;
        $user->save();

        Auth::logout();

        return true;

    }

    public function editChangePassword (Request $request)
    {

     return view('password/editpassword');
    }

    public function changePassword (PasswordRequest $request)
    {
        $user = User::find(auth()->id());
        $user->password = Hash::make($request->password);
        $user->save();
    }
}
