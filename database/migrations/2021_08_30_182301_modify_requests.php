<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('amount');
            $table->float('amount', 18, 2);
        });


        Schema::table('payment_schedule', function (Blueprint $table) {
            $table->dropColumn('loan_body');
            $table->dropColumn('loan_percent');
            $table->dropColumn('amount');
            $table->float('loan_body', 10, 2);
            $table->float('loan_percent', 10, 2);
            $table->float('amount', 10, 2);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
