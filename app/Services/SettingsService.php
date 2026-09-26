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
        $num = $this->get('whatsapp_number');
        if (empty($num) || $num === '201012345678' || $num === '201000000000') {
            $this->set('whatsapp_number', '201112126939');

            return '201112126939';
        }

        return $num;
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
