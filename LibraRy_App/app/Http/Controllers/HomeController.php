<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;

class HomeController extends Controller
{
    public function index()
    {
        $books = Book::with(['categories:id,category',])
            ->inRandomOrder()
            ->take(4)
            ->get();
        return view("home", compact('books'));
    }
}
