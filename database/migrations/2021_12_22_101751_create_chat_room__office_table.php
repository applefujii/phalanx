<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatRoomOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_room__office', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("chat_room_id");
            $table->unsignedBigInteger("office_id");
            $table->unsignedBigInteger("create_user_id");
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
        Schema::dropIfExists('chat_room__office');
    }
}
