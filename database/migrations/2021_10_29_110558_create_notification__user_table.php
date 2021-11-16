<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification__user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_id')->comment("通知テーブルID");;
            $table->unsignedBigInteger('user_id')->comment("ユーザーマスタID");;
            $table->unsignedBigInteger('create_user_id');
            $table->dateTime("created_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification__user');
    }
}
