<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with(["author", "genre"])->get()->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'genre' => $book->genre,
                'description' => $book->description,
                'cover_image' => $book->getFirstMediaUrl('cover_images') ?: null, // Ensure URL is valid
            ];
        });

        return Inertia::render('Books/Index', ['books' => $books]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Books/Create', [
            'authors' => Author::all(),
            'genres' => Genre::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'nullable|exists:genres,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $book = Book::create($request->only(['title', 'author_id', 'genre_id', 'description']));

        if ($request->hasFile('cover_image')) {
            $book->addMediaFromRequest('cover_image')
                ->toMediaCollection('cover_images'); // Ensure it uses the default storage disk
        }

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return Inertia::render('Books/Show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return Inertia::render('Books/Edit', [
            'book' => $book,
            'authors' => Author::all(),
            'genres' => Genre::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'nullable|exists:genres,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $book->update($request->only(['title', 'author_id', 'genre_id', 'description']));

        if ($request->hasFile('cover_image')) {
            $book->clearMediaCollection('cover_images'); // Remove old image
            $book->addMediaFromRequest('cover_image')
                ->toMediaCollection('cover_images'); // Ensure correct storage
        }

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
