<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->index('provider');
            $table->index('status');
            $table->index('created_at');
            $table->index(['name', 'provider']);
        });
    }

    public function down()
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->dropIndex(['provider']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['name', 'provider']);
        });
    }
};
