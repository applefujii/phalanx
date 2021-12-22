<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification__office', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notification_id')->comment("通知テーブルID");;
            $table->unsignedBigInteger('office_id')->comment("事業所ID");;
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
        Schema::dropIfExists('notification__office');
    }
}
