<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الطلب')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('order_number')
                                ->label('رقم الطلب')
                                ->placeholder('يتم إنشاؤه تلقائياً')
                                ->disabled(),

                            Select::make('status')
                                ->label('الحالة')
                                ->options(collect(OrderStatus::cases())->mapWithKeys(
                                    fn ($case) => [$case->value => $case->label()]
                                ))
                                ->default(OrderStatus::Pending->value)
                                ->required(),

                            Select::make('order_type')
                                ->label('نوع الطلب')
                                ->options(collect(OrderType::cases())->mapWithKeys(
                                    fn ($case) => [$case->value => $case->label()]
                                ))
                                ->default(OrderType::ReadyMade->value)
                                ->required(),
                        ]),
                    ]),

                Section::make('معلومات العميل')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('customer_name')
                                ->label('اسم العميل')
                                ->required(),

                            TextInput::make('customer_phone')
                                ->label('رقم الهاتف')
                                ->tel()
                                ->required(),
                        ]),

                        Textarea::make('customer_address')
                            ->label('العنوان')
                            ->columnSpanFull(),

                        Textarea::make('customer_notes')
                            ->label('ملاحظات العميل')
                            ->columnSpanFull(),
                    ]),

                Section::make('التسعير')
                    ->schema([
                        Grid::make(4)->schema([
                            TextInput::make('subtotal')
                                ->label('المجموع الفرعي')
                                ->numeric()
                                ->default(0)
                                ->suffix('ج.م'),

                            TextInput::make('packaging_cost')
                                ->label('تكلفة التغليف')
                                ->numeric()
                                ->default(0)
                                ->suffix('ج.م'),

                            TextInput::make('delivery_cost')
                                ->label('تكلفة التوصيل')
                                ->numeric()
                                ->default(0)
                                ->suffix('ج.م'),

                            TextInput::make('total')
                                ->label('الإجمالي')
                                ->numeric()
                                ->default(0)
                                ->suffix('ج.م'),
                        ]),
                    ]),

                Section::make('عناصر ومحتويات الطلب')
                    ->schema([
                        Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                TextInput::make('name_snapshot')
                                    ->label('اسم العنصر')
                                    ->required(),
                                TextInput::make('quantity')
                                    ->label('الكمية')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                                TextInput::make('unit_price')
                                    ->label('سعر الوحدة')
                                    ->numeric()
                                    ->default(0)
                                    ->suffix('ج.م'),
                                TextInput::make('total_price')
                                    ->label('الإجمالي')
                                    ->numeric()
                                    ->default(0)
                                    ->suffix('ج.م'),
                            ])
                            ->columns(4)
                            ->columnSpanFull()
                            ->addActionLabel('إضافة عنصر للطلب'),
                    ]),
            ]);
    }
}
