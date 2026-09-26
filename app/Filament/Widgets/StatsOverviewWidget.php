<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', OrderStatus::Pending->value)->count();
        $confirmedOrders = Order::where('status', OrderStatus::Confirmed->value)->count();
        $completedOrders = Order::where('status', OrderStatus::Completed->value)->count();
        $totalSales = Order::where('status', OrderStatus::Completed->value)->sum('total');

        return [
            Stat::make('إجمالي الطلبات', $totalOrders)
                ->description('جميع الطلبات')
                ->icon('heroicon-o-shopping-cart')
                ->color('primary'),

            Stat::make('طلبات قيد الانتظار', $pendingOrders)
                ->description('تحتاج متابعة')
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('طلبات مؤكدة', $confirmedOrders)
                ->description('قيد التحضير')
                ->icon('heroicon-o-check-circle')
                ->color('info'),

            Stat::make('طلبات مكتملة', $completedOrders)
                ->description('تم التسليم')
                ->icon('heroicon-o-check-badge')
                ->color('success'),

            Stat::make('إجمالي المبيعات', number_format((float) $totalSales, 2).' ج.م')
                ->description('من الطلبات المكتملة')
                ->icon('heroicon-o-banknotes')
                ->color('success'),
        ];
    }
}
