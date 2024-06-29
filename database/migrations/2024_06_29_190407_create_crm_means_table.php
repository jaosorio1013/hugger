<?php

use App\Models\CrmMean;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('crm_means', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        $contactMeans = [
            'TELÉFONO',
            'WHATSAPP',
            'CORREO',
            'FORMULARIO PÁGINA WEB',
            'REDES',
        ];

        foreach ($contactMeans as $contactMean) {
            CrmMean::create(['name' => $contactMean]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('crm_means');
    }
};
