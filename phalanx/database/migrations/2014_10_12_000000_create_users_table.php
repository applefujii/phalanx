<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_type_id");
            $table->unsignedBigInteger("office_id");
            $table->string('name', 255);
            $table->string('name_katakana', 255);
            $table->string('login_name', 30);
            $table->string('password', 255);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
