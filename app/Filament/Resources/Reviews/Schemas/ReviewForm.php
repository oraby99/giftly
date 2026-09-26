<?php

namespace App\Filament\Resources\Reviews\Schemas;

use App\Enums\ReviewStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    TextInput::make('customer_name')
                        ->label('اسم العميل')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('rating')
                        ->label('التقييم (1 - 5)')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(5)
                        ->default(5)
                        ->required(),

                    Select::make('status')
                        ->label('الحالة')
                        ->options(collect(ReviewStatus::cases())->mapWithKeys(
                            fn ($case) => [$case->value => $case->label()]
                        ))
                        ->default(ReviewStatus::Approved->value)
                        ->required(),
                ]),

                Grid::make(2)->schema([
                    Select::make('product_id')
                        ->label('المنتج المرتبط')
                        ->relationship('product', 'name')
                        ->searchable()
                        ->preload(),

                    Select::make('gift_box_id')
                        ->label('صندوق الهدايا المرتبط')
                        ->relationship('giftBox', 'name')
                        ->searchable()
                        ->preload(),
                ]),

                Textarea::make('comment')
                    ->label('التعليق')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
