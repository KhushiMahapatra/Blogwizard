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
    Schema::table('comment_replies', function (Blueprint $table) {
        $table->boolean('approved')->default(false); // Add the approved column
    });
}

public function down()
{
    Schema::table('comment_replies', function (Blueprint $table) {
        $table->dropColumn('approved'); // Remove the approved column if rolling back
    });
}
};
