<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dropboxes', function (Blueprint $table) {
            $table->id();
            $table->string('app_key')->nullable()->default('app_key');
            $table->string('app_secret')->nullable()->default('app_secret');
            $table->string('refresh_token')->nullable()->default('refresh_token');
            $table->string('access_token')->nullable()->default('access_token');
            $table->string('redirect_url')->nullable()->default('redirect_url');
            $table->string('notify_email')->nullable()->default('example@domain.com');
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
        Schema::dropIfExists('dropboxes');
    }
};
