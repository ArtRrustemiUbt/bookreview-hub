<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Authors/Index', [
            'authors' => Author::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Authors/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'website' => 'nullable|url',
            'twitter' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
        ]);

        $author = Author::create($request->only(['name', 'bio', 'website', 'twitter', 'facebook', 'instagram']));

        if ($request->hasFile('photo')) {
            $author->addMediaFromRequest('photo')->toMediaCollection('author_photos');
        }

        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $author->load('books');

        $author->photo = $author->getFirstMediaUrl('author_photos');

        return Inertia::render('Authors/Show', [
            'author' => $author
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        $author->photo = $author->getFirstMediaUrl('author_photos'); // Get the photo URL

        return Inertia::render('Authors/Edit', [
            'author' => $author
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {  

        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'website' => 'nullable|url',
            'twitter' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
        ]);   

        $author->update($request->only(['name', 'bio', 'website', 'twitter', 'facebook', 'instagram']));

        if ($request->hasFile('photo')) {
            $author->clearMediaCollection('author_photos');

            $author->addMediaFromRequest('photo')->toMediaCollection('author_photos');
        }

        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted');
    }
}
