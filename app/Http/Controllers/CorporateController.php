<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyInquiryRequest;
use App\Models\CompanyInquiry;
use App\Models\CorporateGiftBox;

class CorporateController extends Controller
{
    public function index()
    {
        $corporateBoxes = CorporateGiftBox::active()
            ->orderBy('sort_order')
            ->get();

        return view('corporate', compact('corporateBoxes'));
    }

    public function store(CompanyInquiryRequest $request)
    {
        CompanyInquiry::create($request->validated());

        return back()->with('success', 'شكراً لتواصلك معنا. سنرد عليك في أقرب وقت ممكن.');
    }
}
