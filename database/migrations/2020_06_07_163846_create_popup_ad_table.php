<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePopupAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popup_ad', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->string('photo')->nullable();
            $table->string('video_url')->nullable();
            $table->string('ad_link')->nullable();
            $table->tinyInteger('main');
            $table->smallInteger('is_visible');
            $table->foreignId('restaurant_id')->constrained('restaurant')->onDelete('cascade');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('popup_ad');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
