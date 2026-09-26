<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('الصورة'),

                TextColumn::make('name')
                    ->label('اسم المنتج')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('التصنيف')
                    ->sortable(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->money('EGP')
                    ->sortable(),

                TextColumn::make('stock_quantity')
                    ->label('المخزون')
                    ->numeric()
                    ->placeholder('غير محدود'),

                IconColumn::make('is_active')
                    ->label('متاح')
                    ->boolean(),

                IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('التصنيف')
                    ->relationship('category', 'name'),

                TernaryFilter::make('is_active')
                    ->label('الحالة'),

                TernaryFilter::make('is_featured')
                    ->label('المميزة'),
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
