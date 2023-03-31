<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user->status = 1 ;
        $user->save();

        Auth::logout();

        return true;

    }
}
