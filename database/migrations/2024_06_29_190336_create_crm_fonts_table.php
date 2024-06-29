<?php

use App\Models\CrmFont;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('crm_fonts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        $fonts = [
            'WhatsApp',
            'Teléfono',
            'Facebook',
            'Instagram',
            'Ferias',
            'Eventos',
        ];

        foreach ($fonts as $font) {
            CrmFont::create(['name' => $font]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('crm_fonts');
    }
};
