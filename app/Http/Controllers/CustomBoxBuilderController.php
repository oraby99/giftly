<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Occasion;
use App\Models\PackagingOption;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomBoxBuilderController extends Controller
{
    public function index()
    {
        $occasions = Occasion::where('is_active', true)
            ->orderBy('sort_order')
            ->select(['id', 'name', 'slug'])
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->select(['id', 'name', 'slug'])
            ->get();

        $packagingOptions = PackagingOption::where('is_active', true)
            ->orderBy('sort_order')
            ->select(['id', 'name', 'description', 'price'])
            ->get();

        return view('custom-box-builder', compact('occasions', 'categories', 'packagingOptions'));
    }

    public function products(Request $request): JsonResponse
    {
        $query = Product::active()
            ->select(['id', 'name', 'price', 'image', 'stock_quantity', 'category_id']);

        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->category_id);
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }

        $products = $query->orderBy('name')->paginate(24);

        return response()->json($products);
    }
}
