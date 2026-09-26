<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'category_id', 'name', 'slug', 'description', 'price',
    'image', 'stock_quantity', 'is_active', 'is_featured',
])]
class Product extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function occasions(): BelongsToMany
    {
        return $this->belongsToMany(Occasion::class, 'product_occasion');
    }

    public function giftBoxItems(): HasMany
    {
        return $this->hasMany(GiftBoxItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function isAvailable(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->stock_quantity !== null && $this->stock_quantity <= 0) {
            return false;
        }

        return true;
    }
}
