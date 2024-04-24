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
        Schema::create('plan_service_category_supporting_document_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_service_category_id');
            $table->unsignedBigInteger('supporting_document_category_id');
            $table->integer('sort');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_service_category_supporting_document_items');
    }
};
