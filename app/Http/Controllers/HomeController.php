<?php

namespace App\Http\Controllers;

use App\Enums\ReviewStatus;
use App\Models\GiftBox;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\Review;
use App\Services\SettingsService;

class HomeController extends Controller
{
    public function __construct(private readonly SettingsService $settings) {}

    public function index()
    {
        $occasions = Occasion::where('is_active', true)
            ->orderBy('sort_order')
            ->select(['id', 'name', 'slug', 'image'])
            ->get();

        $featuredGiftBoxes = GiftBox::active()
            ->featured()
            ->with(['occasions:id,name'])
            ->select(['id', 'name', 'slug', 'price', 'image'])
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        $featuredProducts = Product::active()
            ->featured()
            ->select(['id', 'name', 'slug', 'price', 'image'])
            ->limit(8)
            ->get();

        $reviews = Review::where('status', ReviewStatus::Approved->value)
            ->latest()
            ->limit(6)
            ->get();

        return view('home', compact('occasions', 'featuredGiftBoxes', 'featuredProducts', 'reviews'));
    }
}
