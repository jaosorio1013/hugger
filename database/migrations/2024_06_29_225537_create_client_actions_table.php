<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('client_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('crm_action_id');
            $table->foreignId('crm_state_id');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_actions');
    }
};
