<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAltAptitudeQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alt_aptitude_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question', 255);
            $table->unsignedInteger('sort');
            $table->string('offices', 255)->nullable()->default(null);
            $table->string('scores', 255)->nullable()->default(null);
            $table->unsignedBigInteger('create_user_id');
            $table->unsignedBigInteger('update_user_id');
            $table->unsignedBigInteger('delete_user_id')->nullable()->default(null);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->dateTime('deleted_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alt_aptitude_questions');
    }
}
