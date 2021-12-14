<?php
/**
 * 事業所マスタのマイグレーション
 * 
 * @author Fumio Mochizuki
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('office_name', 255);
            $table->string('en_office_name', 255);
            $table->unsignedBigInteger('sort');
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
        Schema::dropIfExists('offices');
    }
}
