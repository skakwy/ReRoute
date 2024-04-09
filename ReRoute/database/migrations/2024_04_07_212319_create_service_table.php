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
                'name' => 'evcc_106',
                'url' => '192.168.108.84:7071'
            )
        );
        DB::table('service')->insert(
            array(
                'name' => 'evcc_113',
                'url' => '192.168.108.84:7072'
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
