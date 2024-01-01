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
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->text('store_name');
            $table->text('store_image')->nullable();
            $table->text('store_contact_number')->nullable();
            $table->text('store_gstin_number')->nullable();
            $table->text('store_address')->nullable();
            $table->text('store_latitude')->nullable();
            $table->text('store_longitude')->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('added_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
