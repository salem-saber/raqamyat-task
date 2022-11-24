<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PaymentApp\TransactionModule\Contexts\TransactionStatus;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedDouble('amount', 15, 2)->comment('The amount of money paid by the user');
            $table->char('currency', 3)->comment('The currency of the user in ISO 4217 format');
            $table->string('mobile')->comment('The email of the parent user');
            $table->string('status')->default(TransactionStatus::PENDING)->comment('The status of the transaction');
            $table->timestamp('payment_date')->nullable()->comment('The date of the payment');
            $table->string('provider_type')->comment('The type of the payment provider');
            $table->string('provider_id')->comment('The id of the payment provider');

            $table->timestamps();


            $table->index('mobile');
            $table->index('status');
            $table->index('payment_date');
            $table->index('provider_type');
            $table->index('provider_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
