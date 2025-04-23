<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LibrarianDashboardController extends Controller
{
    public function index(){
        return view('Librarian.dashboard');
    }
}
