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
        Schema::create('diser_activity_share_of_shelf_baths', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diser_activity_id')->nullable();
            $table->string('brand')->nullable();
            $table->string('size')->nullable();
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
        Schema::dropIfExists('diser_activity_share_of_shelf_baths');
    }
};
