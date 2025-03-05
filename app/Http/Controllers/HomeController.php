<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with(['author', 'genre'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'genre' => $book->genre,
                    'description' => $book->description,
                    'cover_image' => $book->getFirstMediaUrl('cover_images') ?: null,
                ];
            });


        return Inertia::render('Home/Index', [
            'books' => $books,
            'userRole' => Auth::check() ? Auth::user()->getRoleNames()->first() : null,
            'isAuthenticated' => Auth::check(),
        ]);
    }
}
