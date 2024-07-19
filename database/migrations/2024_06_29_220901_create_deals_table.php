<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->index();
            $table->string('client_name')->nullable();
            $table->dateTime('date')->nullable();
            $table->decimal('total', 20)->nullable();
            $table->foreignId('client_id')->nullable();
            $table->foreignId('client_contact_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
