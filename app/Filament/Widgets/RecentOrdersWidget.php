<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersWidget extends BaseWidget
{
    protected static ?string $heading = 'أحدث الطلبات';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Order::latest()->limit(10))
            ->columns([
                TextColumn::make('order_number')
                    ->label('رقم الطلب'),

                TextColumn::make('customer_phone')
                    ->label('الهاتف')
                    ->placeholder('—'),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn ($state) => $state?->label())
                    ->badge()
                    ->color(fn ($state) => $state?->color()),

                TextColumn::make('total')
                    ->label('الإجمالي')
                    ->money('EGP'),

                TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->recordUrl(fn ($record) => OrderResource::getUrl('view', ['record' => $record]));
    }
}
