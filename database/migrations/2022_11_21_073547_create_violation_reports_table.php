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
        Schema::create('violation_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->constrained('user')->cascadeOnDelete();
            $table->foreignId('to_user_id')->constrained('user')->cascadeOnDelete();
            $table->string('title');
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
        Schema::dropIfExists('violation_reports');
    }
};
