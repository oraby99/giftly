<?php

namespace App\Filament\Resources\CompanyInquiries\Tables;

use App\Enums\InquiryStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CompanyInquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_name')
                    ->label('الشركة')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('contact_person')
                    ->label('جهة الاتصال'),

                TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable(),

                TextColumn::make('quantity')
                    ->label('العدد')
                    ->numeric(),

                TextColumn::make('budget')
                    ->label('الميزانية')
                    ->money('EGP')
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
                    ->options(collect(InquiryStatus::cases())->mapWithKeys(
                        fn ($case) => [$case->value => $case->label()]
                    )),
            ])
            ->recordActions([
                EditAction::make()->label('عرض/تعديل'),
                DeleteAction::make()->label('حذف'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->label('حذف المحدد'),
                ]),
            ]);
    }
}
