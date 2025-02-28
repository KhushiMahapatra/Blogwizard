<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AddSlugToPagesTable extends Migration
{
    public function up()
{
    Schema::table('pages', function (Blueprint $table) {
        $table->string('slug')->nullable()->after('title'); // Allow NULL values
    });

    foreach (DB::table('pages')->get() as $page) {
        $slug = Str::slug($page->title);
        $originalSlug = $slug;
        $count = 1;

        // Ensure uniqueness
        while (DB::table('pages')->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        DB::table('pages')->where('id', $page->id)->update(['slug' => $slug]);
    }

    Schema::table('pages', function (Blueprint $table) {
        $table->string('slug')->unique()->nullable(false)->change(); // Set as unique & non-nullable
    });
}

    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
}
