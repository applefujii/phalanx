<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatRoomUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_room__user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("chat_room_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("newest_read_chat_text_id");
            $table->unsignedBigInteger("create_user_id");
            $table->unsignedBigInteger("update_user_id");
            $table->unsignedBigInteger("delete_user_id")->nullable()->default(null);
            $table->dateTime("created_at");
            $table->dateTime("updated_at");
            $table->dateTime("deleted_at")->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_room__user');
    }
}
