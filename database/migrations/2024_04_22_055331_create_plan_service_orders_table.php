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
        Schema::create('plan_service_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('existing_plan_service_order_id')->nullable()->comment('refer own table existing plan');
            $table->unsignedBigInteger('plan_service_category_id');
            $table->integer('status');
            $table->unsignedBigInteger('ward_id');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('user_id')->comment('created user');
            $table->unsignedBigInteger('approved_user_id')->nullable();
            $table->unsignedBigInteger('rejected_user_id')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('approved_remarks')->nullable();
            $table->text('rejected_remarks')->nullable();
            $table->integer('payment_status')->default(0)->comment('1=payment done,0=payment pending');
            $table->float('fees',50);
            $table->string('pso_no')->comment('Plan service order no.')->nullable();
            $table->string('plan_no')->nullable();
            $table->string('name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('nid_no');
            $table->string('mobile_no');
            $table->string('alternative_mobile_no')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_service_orders');
    }
};
