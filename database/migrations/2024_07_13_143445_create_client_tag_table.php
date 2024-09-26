<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_tag', function (Blueprint $table) {
            $table->foreignId('client_id')->nullable()->index();
            $table->foreignId('tag_id')->nullable()->index();
            $table->boolean('registered_on_mailchimp')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_tag');
    }
};
