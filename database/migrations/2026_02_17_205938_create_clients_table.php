<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('telephone', 20)->unique();
        $table->string('email')->nullable();
        $table->text('adresse')->nullable();
        $table->decimal('total_achats', 15, 2)->default(0);
        $table->integer('nombre_achats')->default(0);
        $table->timestamp('dernier_achat_le')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('clients');
    }
};
