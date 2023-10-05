<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeUserDataController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|min:10|max:14'
        ]);

        $user->update([
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        return $user;
    }
}
