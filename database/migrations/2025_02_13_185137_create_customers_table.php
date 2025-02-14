<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();  // Primary Key (auto-incrementing)
            $table->string('name');  // Example: Customer Name
            $table->string('email')->unique(); // Example: Customer Email, unique constraint
            $table->string('phone')->nullable(); // Example: Customer Phone (nullable)
            $table->text('address')->nullable(); // Example: Customer Address (nullable)
            $table->timestamps(); // Created at and Updated at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};