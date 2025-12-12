<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('leads', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('phone')->nullable();
        $table->string('email')->unique();
        $table->enum('source', ['Facebook','Google','Referral','Website']);
        $table->enum('status', ['New','In-Progress','Closed'])->default('New');
        $table->unsignedBigInteger('assigned_to')->nullable();
        $table->timestamps();

        $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
