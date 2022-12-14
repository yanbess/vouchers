<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->float('amount', 8, 2);
            $table->enum('status', ['new', 'cancelled', 'paid'])->default('new');
            $table->timestamp('payed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->float('discount');
            $table->string('code');
            $table->date('expiry_date');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vouchers');
        Schema::drop('orders');
    }
}
