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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string("title", 1024);
            $table->string("slug", 1024);
            $table->text("cover")->nullable();
            $table->text("content")->nullable();
            $table->dateTime("published_at")->nullable();
            $table->boolean("is_active")->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId("created_by")->nullable()->index("created_by_index");
            $table->foreignId("updated_by")->nullable()->index("updated_by_index");
            $table->foreignId("deleted_by")->nullable()->index("deleted_by_index");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
