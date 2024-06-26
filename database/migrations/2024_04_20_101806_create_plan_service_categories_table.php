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
        Schema::create('plan_service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('main_service')->default(0)->comment('1=main service,0=other');
            $table->boolean('is_need_plan_no')->default(0)->comment('1=Yes,0=No');
            $table->integer('sort');
            $table->string('slug')->unique();
            $table->float('fees', 20);
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('alter_user_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_categories');
    }
};
