<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service', function (Blueprint $table) {
            $table->string('name');
            $table->string('url');
            $table->boolean('isHttps')->default(false);
        });
        DB::table('service')->insert(
            array(
                'name' => 'evcc',
                'url' => $_SERVER['REMOTE_ADDR'] + ":7070"
            )
        );
        DB::table('service')->insert(
            array(
                'name' => 'portainer',
                'url' => $_SERVER['REMOTE_ADDR'] + ":9443"
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service');
    }
};
