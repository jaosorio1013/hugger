<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('email')->index();
            $table->string('name')->nullable()->index();
            $table->string('mailchimp_id')->nullable();
            $table->string('charge')->index()->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('client_id')->nullable()->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_contacts');
    }
};
