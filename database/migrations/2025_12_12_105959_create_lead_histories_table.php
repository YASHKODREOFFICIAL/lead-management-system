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
Schema::create('lead_histories', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('lead_id');
    $table->string('previous_status')->nullable();
    $table->string('new_status')->nullable();
    $table->unsignedBigInteger('previous_assigned_user')->nullable();
    $table->unsignedBigInteger('new_assigned_user')->nullable();
    $table->unsignedBigInteger('changed_by');
    $table->timestamps();   // <-- REQUIRED
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_histories');
    }
};
