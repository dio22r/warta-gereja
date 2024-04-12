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
        Schema::create('mortalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->index('member_id_index')->nullable();
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->dateTime('mortality_date')->nullable();
            $table->string('mortality_place')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('created_by')->nullable()->index("created_by_index");
            $table->foreignId('updated_by')->nullable()->index("updated_by_index");
            $table->foreignId('deleted_by')->nullable()->index("deleted_by_index");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mortalities');
    }
};
