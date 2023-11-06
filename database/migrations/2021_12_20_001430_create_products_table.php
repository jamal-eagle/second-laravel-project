<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
                    $table->id();
                    $table->string('name');
                    $table->string('price');
                    $table->date('expiry_date');
                    $table->integer('quantity');
                    $table->string('image')->nullable();
                    $table->string('category');
                    $table->string('contact_info');
                    $table->integer('discount_1')->default(0)->nullable();
                    $table->date('date_1')->nullable();
                    $table->integer('discount_2')->default(0)->nullable();
                    $table->date('date_2')->nullable();
                    $table->integer('discount_3')->default(0)->nullable();
                    $table->date('date_3')->nullable();
                    $table->unsignedBigInteger('user_id');
                    //$table->unsignedBigInteger('category_id');


                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    //$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
