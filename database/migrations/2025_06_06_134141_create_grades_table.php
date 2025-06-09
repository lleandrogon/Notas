<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('discipline_id');
            $table->integer('bimonthly');
            $table->decimal('monthly_note', 5, 2);
            $table->decimal('bimonthly_note', 5, 2);
            $table->decimal('average', 5, 2);
            $table->enum('result', ['approved', 'disapproved']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('discipline_id')->references('id')->on('disciplines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function(Blueprint $table) {
            $table->dropForeign(['discipline_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('grades');
    }
};
