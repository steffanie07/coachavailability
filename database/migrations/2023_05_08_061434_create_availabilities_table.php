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
    Schema::create('availabilities', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('coach_id');
        $table->string('day_of_week');
        $table->time('start_time');
        $table->time('end_time');
        $table->timestamps();

        $table->foreign('coach_id')->references('id')->on('coaches')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};
