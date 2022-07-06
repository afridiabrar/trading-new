<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->string('variant', 255)
                ->nullable()
                ->after('shipping_method_id');
            $table->string('variation', 255)
                ->nullable()
                ->after('variant');
            $table->string('discount_type', 30)
                ->nullable()
                ->after('variation');
            $table->boolean('is_stock_decreased')
                ->default(1)
                ->after('discount_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn(
                [
                    'variant',
                    'variation',
                    'discount_type',
                    'is_stock_decreased'
                ]
            );
        });
    }
}
