<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_networks', function (Blueprint $table) {
            $table->bigIncrements('network_id');
            $table->unsignedBigInteger('organization_id');
         	$table->unsignedBigInteger('creator_id');
         	$table->string('network_name');
         	//$table->timestamp('date_created');
         //Created by
            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_networks');
    }
}
