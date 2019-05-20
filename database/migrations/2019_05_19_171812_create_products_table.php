<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->decimal('price');
            $table->date('date_of_create');
            $table->integer('weight')->unsigned();
            $table->integer('height')->unsigned();
            $table->integer('width')->unsigned();
            $table->integer('length')->unsigned();
            $table->integer('country_id')->unsigned()->index()->default('1'); //Предпологается, что первым значением буде "Неизвестно"
            $table->boolean('in_stock');
            $table->integer('min_age')->default('0');
            $table->string('description');
            $table->integer('manufacturer_id')->unsigned()->index()->default('1'); //Предпологается, что первым значением буде "Другой"
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
        Schema::dropIfExists('products');
    }
}
