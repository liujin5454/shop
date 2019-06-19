<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
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
            $table->unsignedInteger('agent_id')->comment('代理商id');
            $table->string('company_name')->comment('公司名');
            $table->string('phone')->comment('联系号码');
            $table->string('email');
            $table->string('apply_name')->comment('应用名称');
            $table->string('address')->comment('公司地址');
            $table->dateTime('ent_at')->comment('到期时间');
            $table->unsignedInteger('integral_rule')->nullable()->comment('积分兑换规则');
            $table->string('integral_details')->nullable()->comment('积分兑换说明');
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
}
