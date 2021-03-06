<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_account', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('gender', 30);
            $table->string('phone_number', 30);
            $table->date('birthday');
            $table->text('address');
            $table->text('profile_image_url')->nullable();
            $table->timestamps();
        });

        Schema::table('user_account', function ($table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_account');
    }
}
