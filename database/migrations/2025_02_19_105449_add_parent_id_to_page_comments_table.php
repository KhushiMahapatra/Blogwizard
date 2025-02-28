<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('page_comments', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('page_comments')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::table('page_comments', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
