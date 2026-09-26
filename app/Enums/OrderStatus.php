<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Preparing = 'preparing';
    case Shipped = 'shipped';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'في الانتظار',
            self::Confirmed => 'مؤكد',
            self::Preparing => 'قيد التحضير',
            self::Shipped => 'تم الشحن',
            self::Completed => 'مكتمل',
            self::Cancelled => 'ملغي',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Confirmed => 'info',
            self::Preparing => 'primary',
            self::Shipped => 'success',
            self::Completed => 'success',
            self::Cancelled => 'danger',
        };
    }
}
