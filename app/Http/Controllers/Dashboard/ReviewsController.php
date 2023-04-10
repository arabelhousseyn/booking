<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewsController extends Controller
{
    public function __invoke(): View
    {
        $reviews = Review::with(['user', 'reviewable'])->paginate();

        return view('pages.reviews.index', compact('reviews'));
    }
}
