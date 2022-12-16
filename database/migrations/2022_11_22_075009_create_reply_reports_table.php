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
        Schema::create('reply_reports', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->text('model_id');
            $table->foreignId('user_id')->constrained('user')->cascadeOnDelete();
            $table->mediumText('description');
            $table->smallInteger('notification')->default(1);
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
        Schema::dropIfExists('reply_reports');
    }
};
