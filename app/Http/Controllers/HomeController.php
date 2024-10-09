<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
{
    if (Auth::check()) { // Memeriksa apakah user login
        $usertype = Auth::user()->usertype; // Mengambil usertype

        // dd($usertype); // Debug untuk memeriksa nilai usertype

        if ($usertype == 'admin') {
            return view('admin.homeadmin'); // Admin diarahkan ke homeadmin
        } else {
            return view('home'); // User biasa diarahkan ke home
        }
    } else {
        return redirect()->route('login'); // Jika tidak login, arahkan ke login
    }
}

    
}
