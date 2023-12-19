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
        Schema::table('buku', function (Blueprint $table) {
            $table->text('review')->nullable();
            $table->boolean('moderation_status')->default(false);
        });
    }

    public function down()
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('review');
            $table->dropColumn('moderation_status');
        });
    }
};
