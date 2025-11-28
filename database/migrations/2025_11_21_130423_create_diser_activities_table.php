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
        Schema::create('diser_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diser_login_id')->nullable();
            $table->string('area')->nullable();
            $table->string('pms_name')->nullable();
            $table->string('store_in_charge')->nullable();
            $table->text('total_findings')->nullable();
            $table->timestamps();

            $table->foreign('diser_login_id')
                ->references('id')->on('diser_logins')
                ->onDelete('cascade');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diser_activities');
    }
};
