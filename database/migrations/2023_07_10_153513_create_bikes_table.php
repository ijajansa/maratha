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
        Schema::create('bikes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id');
            $table->integer('model_id');
            $table->string('name');
            $table->integer('category_id');
            $table->integer('registration_year_id');
            $table->string('registration_number');
            $table->text('default_address')->nullable();
            $table->integer('price');
            $table->text('lat_lng');
            $table->integer('is_puc')->default(1);
            $table->integer('is_insurance')->default(1);
            $table->integer('is_documents')->default(1);
            $table->integer('dealer_id');
            $table->integer('is_active')->default(1);
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
        Schema::dropIfExists('bikes');
    }
};
