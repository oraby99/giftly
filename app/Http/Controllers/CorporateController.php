<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyInquiryRequest;
use App\Models\CompanyInquiry;
use App\Models\GiftBox;

class CorporateController extends Controller
{
    public function index()
    {
        $exampleBoxes = GiftBox::active()
            ->select(['id', 'name', 'slug', 'price', 'image'])
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        return view('corporate', compact('exampleBoxes'));
    }

    public function store(CompanyInquiryRequest $request)
    {
        CompanyInquiry::create($request->validated());

        return back()->with('success', 'شكراً لتواصلك معنا. سنرد عليك في أقرب وقت ممكن.');
    }
}
