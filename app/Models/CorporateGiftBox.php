<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name', 'slug', 'description', 'price', 'image',
    'min_quantity', 'features', 'is_active', 'sort_order',
])]
class CorporateGiftBox extends Model
{
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'min_quantity' => 'integer',
            'features' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
