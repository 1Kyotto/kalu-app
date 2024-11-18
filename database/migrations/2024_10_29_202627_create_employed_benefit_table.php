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
        Schema::create('employed_benefit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employees_id')->nullable();
            $table->unsignedBigInteger('benefits_id')->nullable();
            $table->date('date_assignment');
            $table->text('details');

            $table->foreign('employees_id')->references('id')->on('employees');
            $table->foreign('benefits_id')->references('id')->on('benefits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employed_benefit');
    }
};
