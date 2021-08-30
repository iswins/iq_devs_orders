<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->float('loan_body');
            $table->float('loan_percent');
            $table->float('amount');
            $table->date('date');
            $table->timestamps();
        });

        Schema::table('payment_schedule', function (Blueprint $table) {
            $table
                ->foreign('request_id')
                ->references('id')->on('requests')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_schedule');
    }
}
