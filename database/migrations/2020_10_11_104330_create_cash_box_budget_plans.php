<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashBoxBudgetPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_box_budget_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cash_box_id');
            $table->string('name');
            $table->double('budget', 8, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('cash_box_id')->references('id')->on('cash_boxes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_box_budget_plans');
    }
}
