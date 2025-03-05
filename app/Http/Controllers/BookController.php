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
                ->toMediaCollection('cover_images');
        }

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {

        $book->load(['author', 'genre', 'reviews.user']);

        $userReview = null;
        if (auth()->check()) {
            $userReview = $book->reviews->firstWhere('user_id', auth()->id());
        }

        $averageRating = $book->reviews->avg('stars');

        return Inertia::render('Books/Show', [
            'book' => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'genre' => $book->genre,
                'description' => $book->description,
                'cover_image' => $book->getFirstMediaUrl('cover_images') ?: null,
                'reviews' => $book->reviews->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'stars' => $review->stars,
                        'comment' => $review->comment,
                        'user' => $review->user->name,
                        'created_at' => $review->created_at->diffForHumans(),
                    ];
                }),
                'average_rating' => round($averageRating, 1),
            ],
            'userReview' => $userReview,
        ]);
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
            $book->clearMediaCollection('cover_images');
            $book->addMediaFromRequest('cover_image')
                ->toMediaCollection('cover_images');
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


    public function duplicate(Request $request)
    {
        $request->validate([
            'book_ids' => 'required|array',
            'book_ids.*' => 'exists:books,id',
        ]);

        foreach ($request->book_ids as $id) {
            $book = Book::with('media')->find($id);

            $newBook = $book->replicate();
            $newBook->title .= ' (Copy)';
            $newBook->save();

            if ($book->hasMedia('cover_images')) {
                foreach ($book->getMedia('cover_images') as $media) {
                    $media->copy($newBook, 'cover_images');
                }
            }
        }

        return redirect()->route('books.index')->with('success', 'Selected books duplicated successfully.');
    }



    public function allBooks(Request $request)
    {
        $query = Book::with(['author', 'genre']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        if ($request->has('sort_by')) {
            if ($request->sort_by === 'author') {
                $query->whereHas('author')->orderBy(
                    Author::select('name')->whereColumn('authors.id', 'books.author_id')
                );
            } elseif ($request->sort_by === 'genre') {
                $query->whereHas('genre')->orderBy(
                    Genre::select('name')->whereColumn('genres.id', 'books.genre_id')
                );
            }
        }

        $books = $query->paginate(9)->withQueryString()
            ->through(function ($book) {
                return [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'genre' => $book->genre,
                    'description' => $book->description,
                    'cover_image' => $book->getFirstMediaUrl('cover_images') ?: null,
                ];
            });

        $authors = Author::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Books/AllBooks', [
            'books' => $books,
            'authors' => $authors,
            'filters' => $request->only('search', 'sort_by', 'author_id'),
        ]);
    }
}
