<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('pages', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft'); // Default is draft
            $table->timestamp('published_at')->nullable(); // Nullable for drafts and immediate publish
        });
    }

    public function down() {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['status', 'published_at']);
        });
    }
};
