<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->date('date');
            $table->string('login_time');
            $table->string('logout_time');
            $table->string('total_login_hours');
            $table->string('break_time');
            $table->string('overtime');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
