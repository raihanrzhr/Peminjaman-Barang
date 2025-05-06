<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_instances', function (Blueprint $table) {
            $table->id('instance_id');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('item_id')->on('items')->onDelete('cascade');
            $table->text('specifications');
            $table->date('date_added')->default(DB::raw('CURRENT_DATE'));
            $table->enum('status', ['Available', 'Unavailable'])->default('Available');
            $table->enum('condition_status', ['Good', 'Damaged'])->default('Good');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_instances');
    }
};
