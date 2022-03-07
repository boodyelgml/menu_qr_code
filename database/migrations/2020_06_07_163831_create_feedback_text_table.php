<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFeedbackTextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_text', function (Blueprint $table) {
            $table->id();
            $table->string('branch_id')->nullable();
            $table->text('feedback')->nullable();
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
        Schema::dropIfExists('feedback_text');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
