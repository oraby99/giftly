<?php

namespace App\Filament\Resources\GiftBoxes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class GiftBoxesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('الصورة'),

                TextColumn::make('name')
                    ->label('اسم الصندوق')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->money('EGP')
                    ->sortable(),

                TextColumn::make('items_count')
                    ->label('المنتجات')
                    ->counts('items')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('متاح')
                    ->boolean(),

                IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                TernaryFilter::make('is_active')->label('الحالة'),
                TernaryFilter::make('is_featured')->label('المميزة'),
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
