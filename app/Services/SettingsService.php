<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    public function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting:{$key}", 3600, function () use ($key, $default) {
            $setting = Setting::find($key);

            return $setting?->value ?? $default;
        });
    }

    public function set(string $key, mixed $value): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("setting:{$key}");
    }

    public function whatsappNumber(): string
    {
        return $this->get('whatsapp_number', '');
    }

    public function storeName(): string
    {
        return $this->get('store_name', 'Giftly');
    }

    public function all(): array
    {
        return Setting::all()->pluck('value', 'key')->toArray();
    }
}
