<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('content', 500)->comment("通知の内容");
            $table->dateTime("start_at")->comment("通知内容の開始日時");
            $table->dateTime("end_at")->comment("通知内容の終了日時");
            $table->boolean("is_all_day")->comment("予定が終日かどうか");
            $table->unsignedBigInteger('create_user_id');
            $table->unsignedBigInteger('update_user_id');
            $table->unsignedBigInteger('delete_user_id')->nullable()->default(null);
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
        Schema::dropIfExists('notifications');
    }
}
