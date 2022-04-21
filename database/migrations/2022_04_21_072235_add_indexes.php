<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->bigInteger('registration_id')->unsigned()->change();
            // $table->foreign('registration_id')->references("id")->on("registrations");

            $table->bigInteger('question_id')->unsigned()->change();
            // $table->foreign('question_id')->references("id")->on("questions");
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->bigInteger('challenge_id')->unsigned()->change();
            // $table->foreign('challenge_id')->references("id")->on("challenges");

            $table->bigInteger('user_id')->unsigned()->change();
            $table->foreign('user_id')->references("id")->on("users");
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->bigInteger('set_id')->unsigned()->change();
            $table->foreign('set_id')->references("id")->on("sets");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
