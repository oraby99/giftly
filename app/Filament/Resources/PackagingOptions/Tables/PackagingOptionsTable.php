<?php

namespace App\Filament\Resources\PackagingOptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PackagingOptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('التغليف')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->money('EGP')
                    ->sortable(),

                TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(50),

                IconColumn::make('is_active')
                    ->label('مفعّل')
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
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
