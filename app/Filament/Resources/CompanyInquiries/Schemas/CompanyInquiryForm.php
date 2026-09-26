<?php

namespace App\Filament\Resources\CompanyInquiries\Schemas;

use App\Enums\InquiryStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class CompanyInquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    TextInput::make('company_name')
                        ->label('اسم الشركة')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('contact_person')
                        ->label('جهة الاتصال')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('phone')
                        ->label('الهاتف')
                        ->tel()
                        ->required(),

                    TextInput::make('email')
                        ->label('البريد الإلكتروني')
                        ->email(),

                    TextInput::make('quantity')
                        ->label('عدد الصناديق المطلوبة')
                        ->numeric()
                        ->required()
                        ->minValue(1),

                    TextInput::make('budget')
                        ->label('الميزانية المقدرة')
                        ->numeric()
                        ->suffix('ج.م'),

                    Select::make('status')
                        ->label('الحالة')
                        ->options(collect(InquiryStatus::cases())->mapWithKeys(
                            fn ($case) => [$case->value => $case->label()]
                        ))
                        ->default(InquiryStatus::New->value)
                        ->required(),
                ]),

                Textarea::make('message')
                    ->label('تفاصيل الطلب / الرسالة')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
