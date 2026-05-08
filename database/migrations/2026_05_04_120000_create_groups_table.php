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
        Schema::create('groups', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('subject');
            $blueprint->string('avatar')->nullable();
            $blueprint->unsignedBigInteger('created_by');
            $blueprint->timestamps();

            $blueprint->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('group_members', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->unsignedBigInteger('group_id');
            $blueprint->unsignedBigInteger('user_id');
            $blueprint->timestamps();

            $blueprint->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            $blueprint->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_members');
        Schema::dropIfExists('groups');
    }
};
