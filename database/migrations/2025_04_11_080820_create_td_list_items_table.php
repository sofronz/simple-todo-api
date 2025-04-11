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
        Schema::create('td_list_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('list_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status');

            $table->timestamps();

            $table->foreign('list_id')
                ->references('id')
                ->on('td_list_items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('td_list_items');
    }
};
