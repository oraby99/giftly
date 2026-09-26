<?php

namespace App\Http\Controllers;

use App\Enums\ReviewStatus;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['nullable', 'exists:products,id'],
            'gift_box_id' => ['nullable', 'exists:gift_boxes,id'],
            'order_id' => ['nullable', 'exists:orders,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'customer_name' => ['required', 'string', 'max:255'],
        ], [
            'customer_name.required' => 'الاسم مطلوب لإضافة التقييم.',
            'rating.required' => 'يرجى تحديد التقييم من 1 إلى 5 نجوم.',
        ]);

        Review::create([
            'product_id' => $validated['product_id'] ?? null,
            'gift_box_id' => $validated['gift_box_id'] ?? null,
            'order_id' => $validated['order_id'] ?? null,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'customer_name' => $validated['customer_name'],
            'status' => ReviewStatus::Pending->value,
        ]);

        return back()->with('success', 'شكراً لمشاركتك رأيك! تم استلام تقييمك بنجاح وسينشر قريباً.');
    }
}
