<?php
// database/migrations/2024_01_01_000006_create_payrolls_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->tinyInteger('month');
            $table->date('period_start');
            $table->date('period_end');
            $table->enum('status', ['draft', 'processed', 'paid', 'cancelled'])->default('draft');
            $table->dateTime('processed_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('employees');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['year', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
