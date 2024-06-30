<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mailchimp_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('mailchimp_id');
            $table->string('name');
            $table->string('subject');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mailchimp_campaigns');
    }
};
