<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsernameColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laracasts', function (Blueprint $table) {
            $table->string('username')->after('user_id');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->string('vendor')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laracasts', function (Blueprint $table) {
            $table->dropColumn('username');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('vendor');
        });
    }
}
