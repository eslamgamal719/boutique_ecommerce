<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('type');
            $table->unsignedBigInteger('value')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('use_times')->nullable();
            $table->unsignedBigInteger('used_times')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->unsignedDecimal('greater_than')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
