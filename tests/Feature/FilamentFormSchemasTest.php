<?php

use App\Filament\Resources\Categories\Schemas\CategoryForm;
use App\Filament\Resources\CompanyInquiries\Schemas\CompanyInquiryForm;
use App\Filament\Resources\GiftBoxes\Schemas\GiftBoxForm;
use App\Filament\Resources\Occasions\Schemas\OccasionForm;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\PackagingOptions\Schemas\PackagingOptionForm;
use App\Filament\Resources\Products\Schemas\ProductForm;
use App\Filament\Resources\Reviews\Schemas\ReviewForm;
use Filament\Schemas\Schema;

test('all filament resource forms can configure schema without errors', function () {
    $forms = [
        CategoryForm::class,
        CompanyInquiryForm::class,
        GiftBoxForm::class,
        OccasionForm::class,
        OrderForm::class,
        PackagingOptionForm::class,
        ProductForm::class,
        ReviewForm::class,
    ];

    foreach ($forms as $formClass) {
        $schema = Schema::make();
        $configured = $formClass::configure($schema);
        expect($configured)->toBeInstanceOf(Schema::class);
        expect($configured->getComponents())->not->toBeEmpty();
    }
});
