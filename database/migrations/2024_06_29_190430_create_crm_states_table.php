<?php

use App\Models\CrmState;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('crm_states', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        $states = [
            'Contactado',
            'Segundo contacto',
        ];

        foreach ($states as $state) {
            CrmState::create(['name' => $state]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('crm_states');
    }
};
