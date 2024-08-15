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
        Schema::create('borrowing_record', function (Blueprint $table) {
            $table->id();

            //books_table
            $table->foreignId('book_id')->nullable();
            //patrons_table
            $table->foreignId('patron_id')->nullable();

            $table->date('borrowing_date')->nullable(); 
            $table->date('return_date')->nullable(); 
             
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing_record');
    }
};
