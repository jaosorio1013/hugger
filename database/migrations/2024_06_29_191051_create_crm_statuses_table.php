<?php

use App\Models\CrmStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('crm_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        $statuses = [
            'prospecto',
            'cita',
            'cotizado',
            'vendido',
        ];

        foreach ($statuses as $status) {
            CrmStatus::create(['name' => $status]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('crm_statuses');
    }
};
