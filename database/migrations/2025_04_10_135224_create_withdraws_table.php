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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('reference_no')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('bank')->nullable();
            $table->string('bank_acc')->nullable();
            $table->double('amount')->nullable();
            $table->string('status')->nullable();
            $table->text('receipt')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraws');
    }
};
