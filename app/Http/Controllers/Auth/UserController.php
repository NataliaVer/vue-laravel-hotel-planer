<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() {
        return auth()->user();
    }

    public function isGuest() {
        return auth()->guest();
    }

    public function authenticated() {
        $id = Auth::id();
        return $id ? '' : 1;
    }
}
