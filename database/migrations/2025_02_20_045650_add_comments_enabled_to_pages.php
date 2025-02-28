<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('comments_enabled')->default(true); // True means comments are enabled
        });
    }

    public function down() {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('comments_enabled');
        });
    }
};
