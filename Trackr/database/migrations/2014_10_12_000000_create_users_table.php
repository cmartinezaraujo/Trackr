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
            $table->bigIncrements('id'); //Change this to our ID
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('account_type', ['user', 'organization']);
            $table->enum('status', ['healthy', 'sick', 'quarantine']);
            $table->enum('vaccinated', ['yes', 'no', 'NA']);
            $table->timestamp('last_login'); //Also check time zone 
            $table->timestamps();
            $table->rememberToken();
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
