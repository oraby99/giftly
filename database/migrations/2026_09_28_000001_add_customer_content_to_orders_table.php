<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'customer_photos')) {
                $table->json('customer_photos')->nullable()->after('customer_notes');
            }
            if (! Schema::hasColumn('orders', 'customer_messages')) {
                $table->json('customer_messages')->nullable()->after('customer_photos');
            }
            if (! Schema::hasColumn('orders', 'photos_received_at')) {
                $table->timestamp('photos_received_at')->nullable()->after('customer_messages');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['customer_photos', 'customer_messages', 'photos_received_at']);
        });
    }
};
