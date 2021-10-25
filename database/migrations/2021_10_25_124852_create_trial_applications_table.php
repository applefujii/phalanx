<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trial_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 512);
            $table->string('name_kana', 512);
            $table->unsignedBigInteger('office_id');
            $table->date('desired_date');
            $table->string('email', 512);
            $table->string('phone_number', 255);
            $table->boolean('is_checked')->default(false);
            $table->unsignedBigInteger('update_user_id')->nullable()->default(null);
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
        Schema::dropIfExists('trial_applications');
    }
}
