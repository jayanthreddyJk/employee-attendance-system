<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('punchstatuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('emp_id');
            $table->enum('punch_type',['in','out']);
            $table->timestamps();
            $table->foreign('emp_id')->references('emp_id')->on('employees')->onDelete('cascade');
        });

    }
    public function down(): void
    {
        Schema::dropIfExists('punchstatuses');
    }
};
