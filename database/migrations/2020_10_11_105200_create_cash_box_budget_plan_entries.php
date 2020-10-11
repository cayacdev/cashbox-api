<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashBoxBudgetPlanEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_box_budget_plan_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cash_box_budget_plan_id');
            $table->date('date');
            $table->double('value', 8,2);
            $table->string('description');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cash_box_budget_plan_id')->references('id')->on('cash_box_budget_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_box_budget_plan_entries');
    }
}
