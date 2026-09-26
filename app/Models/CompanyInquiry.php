<?php

namespace App\Models;

use App\Enums\InquiryStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'company_name', 'contact_person', 'phone', 'email',
    'quantity', 'budget', 'message', 'status',
])]
class CompanyInquiry extends Model
{
    protected function casts(): array
    {
        return [
            'status' => InquiryStatus::class,
            'budget' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }
}
