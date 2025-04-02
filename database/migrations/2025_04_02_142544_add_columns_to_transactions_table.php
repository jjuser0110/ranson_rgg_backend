<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dateTime('datetime')->nullable()->after('transaction_no');
            $table->integer('user_id')->after('datetime');
            $table->string('payment')->nullable()->after('amount');
            $table->string('status')->nullable()->after('payment');
            $table->text('bank_receipt')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('datetime');
            $table->dropColumn('user_id');
            $table->dropColumn('payment');
            $table->dropColumn('status');
            $table->dropColumn('bank_receipt');
        });
    }
};
