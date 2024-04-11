<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('member_church_group', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->index('member_id_index');
            $table->foreignId('church_group_id')->index('church_group_id_index');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_church_group');
    }
};
