<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChallengeSetIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('challenge_set', function (Blueprint $table) {
            $table->bigInteger('challenge_id')->unsigned()->change();
            // $table->foreign('challenge_id')->references("id")->on("challenges");

            $table->bigInteger('set_id')->unsigned()->change();
            // $table->foreign('set_id')->references("id")->on("sets");
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
