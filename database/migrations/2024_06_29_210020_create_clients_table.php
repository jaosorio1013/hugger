<?php

use App\Models\Client;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nit')->index();
            $table->string('name')->nullable()->index();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('mailchimp_id')->nullable();
            $table->unsignedTinyInteger('type')->default(Client::TYPE_NATURAL)->index();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('crm_font_id')->nullable();
            $table->foreignId('location_city_id')->nullable();
            $table->foreignId('crm_pipeline_stage_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
