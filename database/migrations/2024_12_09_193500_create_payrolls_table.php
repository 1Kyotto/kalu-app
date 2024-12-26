<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employees_id');
            $table->string('file_url');
            $table->string('period'); // Ejemplo: "2024-01" para enero 2024
            $table->decimal('amount', 10, 2);
            $table->date('issue_date');
            $table->timestamps();

            $table->foreign('employees_id')->references('id')->on('employees');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
