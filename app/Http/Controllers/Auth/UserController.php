<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return auth()->user();
    }

    public function isGuest() {
        return auth()->guest();
    }
}
