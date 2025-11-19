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
        Schema::create('diser_account', function (Blueprint $table) {
            $table->unsignedBigInteger('diser_id_number_id');
            $table->unsignedBigInteger('account_id');

            $table->primary(['diser_id_number_id', 'account_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diser_account');
    }
};
