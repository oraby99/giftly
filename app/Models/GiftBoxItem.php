<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['gift_box_id', 'product_id', 'quantity'])]
class GiftBoxItem extends Model
{
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }

    public function giftBox(): BelongsTo
    {
        return $this->belongsTo(GiftBox::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
