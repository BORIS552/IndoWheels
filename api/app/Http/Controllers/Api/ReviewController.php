<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Review;

class ReviewController extends Controller
{
    /**
     * Get terms and conditions
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return Review::where('is_active', true)
            ->whereNotNull('photo')
            ->with(['author'])
            ->whereHas('author')
            ->latest()
            ->get();
    }

    /**
     * Get all published reviews with videos
     *
     * @return Illuminate\Http\Response
     */
    public function videos()
    {
        return Review::where('is_active', true)
            ->whereNotNull('video')
            ->with(['author'])
            ->latest()
            ->get();
    }
}
