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
        Schema::create('borrowing_details', function (Blueprint $table) {
            $table->id('detail_id');
            $table->foreignId('borrowing_id');
            $table->foreign('borrowing_id')->references('borrowing_id')->on('borrowing')->onDelete('cascade');
            $table->unsignedBigInteger('instance_id'); // Foreign key
            $table->foreign('instance_id')->references('instance_id')->on('item_instances')->onDelete('cascade');
            $table->date('borrowing_date')->default(DB::raw('CURRENT_DATE'));
            $table->date('planned_return_date');
            $table->date('return_date')->nullable();
            $table->enum('return_status', ['Returned', 'Not Returned'])->default('Not Returned');
            $table->string('return_proof')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing_details');
    }
};
