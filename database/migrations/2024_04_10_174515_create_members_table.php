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
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('family_id')->index('family_id')->nullable();

            $table->string('nik')->nullable();
            $table->string('kk_number')->nullable();
            $table->string('name');
            $table->string('gender', 1);
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('blood_group', 3)->nullable();
            $table->string('address')->nullable();
            $table->string('telp')->nullable();
            $table->string('email')->nullable();
            $table->string('marital_status', 1)->nullable();
            $table->boolean('is_baptized')->nullable();
            $table->string('activity_status')->nullable();
            $table->tinyInteger('status');

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
        Schema::dropIfExists('members');
    }
};
