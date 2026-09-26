<?php

namespace App\Enums;

enum ItemType: string
{
    case Product = 'product';
    case ReadyMadeGiftBox = 'ready_made_gift_box';
    case CustomGiftBox = 'custom_gift_box';

    public function label(): string
    {
        return match ($this) {
            self::Product => 'منتج',
            self::ReadyMadeGiftBox => 'صندوق هدايا جاهز',
            self::CustomGiftBox => 'صندوق هدايا مخصص',
        };
    }
}
