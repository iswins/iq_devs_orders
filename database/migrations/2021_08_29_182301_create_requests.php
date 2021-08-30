<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->float('amount');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->float('rate');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('term');
            $table->string('inn');
            $table->timestamps();
        });

        Schema::table('requests', function (Blueprint $table) {
            $table
                ->foreign('status_id')
                ->references('id')->on('statuses')
                ->onDelete('set null');

            $table
                ->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
