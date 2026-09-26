<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('رقم الطلب')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('customer_phone')
                    ->label('الهاتف')
                    ->searchable(),

                TextColumn::make('order_type')
                    ->label('النوع')
                    ->formatStateUsing(fn ($state) => $state?->label())
                    ->badge(),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn ($state) => $state?->label())
                    ->badge()
                    ->color(fn ($state) => $state?->color()),

                TextColumn::make('total')
                    ->label('الإجمالي')
                    ->money('EGP')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(collect(OrderStatus::cases())->mapWithKeys(
                        fn ($case) => [$case->value => $case->label()]
                    )),

                SelectFilter::make('order_type')
                    ->label('النوع')
                    ->options(collect(OrderType::cases())->mapWithKeys(
                        fn ($case) => [$case->value => $case->label()]
                    )),
            ])
            ->recordActions([
                ViewAction::make()->label('عرض'),
                EditAction::make()->label('تعديل'),
                DeleteAction::make()->label('حذف'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }
}
