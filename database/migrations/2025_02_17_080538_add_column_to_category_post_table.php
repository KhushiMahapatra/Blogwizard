<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('category_post', function (Blueprint $table) {
            // Add a new column, for example, created_by
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('category_post', function (Blueprint $table) {
            // Drop the column if it exists
            $table->dropForeign(['created_by']); // Drop foreign key constraint
            $table->dropColumn('created_by'); // Drop the column
        });
    }
};
