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
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_drive_refresh_token')->nullable();
            $table->string('chat_backup_frequency')->default('Off');
            $table->timestamp('last_chat_backup_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_drive_refresh_token');
            $table->dropColumn('chat_backup_frequency');
            $table->dropColumn('last_chat_backup_at');
        });
    }
};
