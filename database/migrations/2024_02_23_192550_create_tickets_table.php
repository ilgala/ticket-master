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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('owner_id');
            $table->foreignUuid('')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->uuid('department_id');
            $table->foreignUuid('')
                ->references('id')
                ->on('departments')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('body');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
