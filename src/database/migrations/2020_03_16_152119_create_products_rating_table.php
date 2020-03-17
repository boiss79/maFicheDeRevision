<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_rating', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rating');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_ratings');
    }
}