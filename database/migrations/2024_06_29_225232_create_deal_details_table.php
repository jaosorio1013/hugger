<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('deal_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id');
            $table->foreignId('client_id');
            $table->foreignId('product_id');
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('price')->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deal_details');
    }
};
