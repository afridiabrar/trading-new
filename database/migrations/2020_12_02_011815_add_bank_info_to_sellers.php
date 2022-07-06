<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankInfoToSellers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('remember_token');
            $table->string('branch')->nullable()->after('bank_name');
            $table->string('account_no')->nullable()->after('branch');
            $table->string('holder_name')->nullable()->after('account_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(
                [
                    'bank_name',
                    'branch',
                    'account_no',
                    'holder_name'
                ]
            );
        });
    }
}
