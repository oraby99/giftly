<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Occasion;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()
            ->with(['category:id,name,slug'])
            ->select(['id', 'name', 'slug', 'price', 'image', 'category_id', 'stock_quantity', 'is_featured']);

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('occasion')) {
            $query->whereHas('occasions', fn ($q) => $q->where('slug', $request->occasion));
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->price_max);
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }

        $sortField = $request->get('sort', 'id');
        $sortDir = $request->get('dir', 'desc');

        $allowedSorts = ['price', 'id'];
        if (! in_array($sortField, $allowedSorts)) {
            $sortField = 'id';
        }

        $query->orderBy($sortField, $sortDir === 'asc' ? 'asc' : 'desc');

        $products = $query->paginate(16)->withQueryString();

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->select(['id', 'name', 'slug'])
            ->get();

        $occasions = Occasion::where('is_active', true)
            ->orderBy('sort_order')
            ->select(['id', 'name', 'slug'])
            ->get();

        return view('products.index', compact('products', 'categories', 'occasions'));
    }

    public function show(string $slug)
    {
        $product = Product::active()
            ->with([
                'category:id,name,slug',
                'images',
                'occasions:id,name,slug',
                'reviews' => fn ($q) => $q->approved()->latest()->limit(10),
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->select(['id', 'name', 'slug', 'price', 'image'])
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
