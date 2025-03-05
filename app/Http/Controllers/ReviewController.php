<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\AdminNotification;

class ReviewController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'book_id' => 'required|exists:books,id',
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = Review::create([
            'book_id' => $request->book_id,
            'user_id' => auth()->id(),
            'stars' => $request->stars,
            'comment' => $request->comment,
        ]);

        AdminNotification::create([
            'type' => 'new_review',
            'message' => 'A new review has been submitted!',
            'data' => [
                'review_id' => $review->id,
                'book_id' => $review->book_id,
                'user_id' => $review->user_id,
                'stars' => $review->stars,
                'comment' => $review->comment,
            ],
            'is_read' => false,
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }
}
