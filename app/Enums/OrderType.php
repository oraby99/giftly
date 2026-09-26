<?php

namespace App\Enums;

enum OrderType: string
{
    case ReadyMade = 'ready_made';
    case Custom = 'custom';
    case Mixed = 'mixed';

    public function label(): string
    {
        return match ($this) {
            self::ReadyMade => 'صندوق جاهز',
            self::Custom => 'صندوق مخصص',
            self::Mixed => 'مختلط',
        };
    }
}
