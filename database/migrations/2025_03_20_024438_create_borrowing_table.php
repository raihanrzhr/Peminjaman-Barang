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
        Schema::create('borrowing', function (Blueprint $table) {
            $table->id('borrowing_id');
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');
            $table->foreignId('borrower_id')->constrained('borrowers')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('admin')->onDelete('cascade');
            $table->date('borrowing_date')->default(DB::raw('CURRENT_DATE'));
            $table->date('planned_return_date');
            $table->date('return_date')->nullable();
            $table->enum('return_status', ['Returned', 'Not Returned'])->default('Not Returned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing');
    }
};
