<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('page_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade'); // Foreign key to pages
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Nullable user ID
            $table->text('comment');
            $table->boolean('approved')->default(false); // Default is not approved
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('page_comments');
    }
};
