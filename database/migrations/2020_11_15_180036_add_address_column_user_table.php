<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressColumnUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('street_address', 250)
                ->nullable()
                ->after('remember_token');
            $table->string('country', 50)
                ->nullable()
                ->after('street_address');
            $table->string('city', 50)
                ->nullable()
                ->after('country');
            $table->string('zip', 20)
                ->nullable()
                ->after('city');
            $table->string('house_no', 50)
                ->nullable()
                ->after('zip');
            $table->string('apartment_no', 50)
                ->nullable()
                ->after('house_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(
                [
                    'street_address',
                    'country',
                    'city',
                    'zip',
                    'house_no',
                    'apartment_no'
                ]
            );
        });
    }
}
