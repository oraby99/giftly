<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Enums\ReviewStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name')
                    ->label('العميل')
                    ->searchable(),

                TextColumn::make('rating')
                    ->label('التقييم')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state)),

                TextColumn::make('comment')
                    ->label('التعليق')
                    ->limit(60),

                TextColumn::make('product.name')
                    ->label('المنتج')
                    ->placeholder('—'),

                TextColumn::make('giftBox.name')
                    ->label('الصندوق')
                    ->placeholder('—'),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn ($state) => $state?->label())
                    ->badge()
                    ->color(fn ($state) => $state?->color()),

                TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(collect(ReviewStatus::cases())->mapWithKeys(
                        fn ($case) => [$case->value => $case->label()]
                    )),
            ])
            ->recordActions([
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
