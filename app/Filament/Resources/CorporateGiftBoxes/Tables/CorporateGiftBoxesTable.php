<?php

namespace App\Filament\Resources\CorporateGiftBoxes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CorporateGiftBoxesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('الصورة')
                    ->disk('public'),

                TextColumn::make('name')
                    ->label('اسم الصندوق')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('يبدأ من')
                    ->money('EGP')
                    ->placeholder('حسب الطلب')
                    ->sortable(),

                TextColumn::make('min_quantity')
                    ->label('الحد الأدنى')
                    ->suffix(' علبة')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('متاح')
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                TernaryFilter::make('is_active')->label('الحالة'),
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
