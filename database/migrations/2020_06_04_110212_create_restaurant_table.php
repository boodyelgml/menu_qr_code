<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->unique()->nullable();
            $table->string('name')->unique()->nullable();
            $table->string('type_ar')->nullable();
            $table->string('type')->nullable();
            $table->string('address')->nullable();
            $table->string('address_ar')->nullable();
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('website')->nullable();
            $table->tinyInteger('language')->default(0)->unsigned();
            $table->smallInteger('theme')->default(0);
            $table->string('phone_number')->nullable();
            $table->text('logo');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('restaurant');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
