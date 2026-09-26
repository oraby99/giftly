<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'slug', 'description', 'image', 'is_active', 'sort_order'])]
class Occasion extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_occasion');
    }

    public function giftBoxes(): BelongsToMany
    {
        return $this->belongsToMany(GiftBox::class, 'gift_box_occasion');
    }
}
