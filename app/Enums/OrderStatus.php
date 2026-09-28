<?php

namespace App\Enums;

enum OrderStatus: string
{
    case New = 'new';
    case WaitingPhotos = 'waiting_photos';
    case PhotosReceived = 'photos_received';
    case Preparing = 'preparing';
    case Ready = 'ready';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    // Backwards compatibility for existing records
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Shipped = 'shipped';

    public function label(): string
    {
        return match ($this) {
            self::New => 'طلب جديد',
            self::WaitingPhotos => 'في انتظار الصور والرسائل',
            self::PhotosReceived => 'تم استلام الصور والرسائل',
            self::Preparing => 'جاري تجهيز البوكس',
            self::Ready => 'جاهز للتوصيل',
            self::Completed => 'مكتمل',
            self::Cancelled => 'ملغي',
            self::Pending => 'في الانتظار',
            self::Confirmed => 'مؤكد',
            self::Shipped => 'تم الشحن',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::New => 'info',
            self::WaitingPhotos => 'warning',
            self::PhotosReceived => 'primary',
            self::Preparing => 'primary',
            self::Ready => 'success',
            self::Completed => 'success',
            self::Cancelled => 'danger',
            self::Pending => 'warning',
            self::Confirmed => 'info',
            self::Shipped => 'success',
        };
    }
}
