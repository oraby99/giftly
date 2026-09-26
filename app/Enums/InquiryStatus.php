<?php

namespace App\Enums;

enum InquiryStatus: string
{
    case New = 'new';
    case InReview = 'in_review';
    case Quoted = 'quoted';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::New => 'جديد',
            self::InReview => 'قيد المراجعة',
            self::Quoted => 'تم تقديم العرض',
            self::Closed => 'مغلق',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::New => 'info',
            self::InReview => 'warning',
            self::Quoted => 'success',
            self::Closed => 'gray',
        };
    }
}
