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
            $table->increments('id');
            $table->unsignedInteger('store_id');
            $table->unsignedInteger('category_id')->comment('分类id');
            $table->string('name');
            $table->string('img_url')->comment('商品预览图');
            $table->boolean('is_buy')->default(true)->comment('是否上架');
            $table->unsignedInteger('count')->comment('销量');
            $table->unsignedInteger('stock')->comment('库存');
            $table->decimal('price',10,2)->comment('售价');
            $table->decimal('original_price',10,2)->comment('原价，只做展示');
            $table->text('details')->comment('详情');
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
