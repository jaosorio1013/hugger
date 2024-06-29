<?php

use App\Models\CrmAction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('crm_actions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        $actions = [
            'Llamada',
            'Email',
            'Cotización',
            'Reunión',
            'Prospección',
            CrmAction::SCHEDULE_CAMPAIGN,
        ];

        foreach ($actions as $action) {
            CrmAction::create(['name' => $action]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('crm_actions');
    }
};
