<?php

use App\Models\CrmPipelineStage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('crm_pipeline_stages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('position')->default(0);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        $pipelineStages = [
            [
                'name' => 'Prospecto',
                'position' => 1,
                'is_default' => true,
            ],
            [
                'name' => 'Cita',
                'position' => 2,
            ],
            [
                'name' => 'Cotizado',
                'position' => 3,
            ],
            [
                'name' => 'Vendido',
                'position' => 98,
            ],
            [
                'name' => 'Rechazado',
                'position' => 99,
            ],
        ];

        foreach ($pipelineStages as $stage) {
            CrmPipelineStage::create($stage);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('crm_pipeline_stages');
    }
};
