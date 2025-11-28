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
        Schema::create('diser_activity_o_s_a_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diser_activity_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('inventory_count')->nullable();
            $table->integer('maxcap_target')->nullable();
            $table->timestamps();

            $table->foreign('diser_activity_id')
                ->references('id')->on('diser_activities')
                ->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diser_activity_o_s_a_s');
    }
};
