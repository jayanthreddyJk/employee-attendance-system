<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('emp_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role');
            $table->enum('trashed',['0','1'])->default('0');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE employees AUTO_INCREMENT = 1000;');
    }


    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
