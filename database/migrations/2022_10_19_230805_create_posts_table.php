<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id');
            $table->text('description')->nullable();
            $table->string('file')->nullable();
            $table->string('filename')->nullable();
            $table->string('mime_type')->nullable();
            $table->bigInteger('size')->nullable();
            $table->string('tags')->nullable();
            $table->string('video')->nullable();
            $table->string('original_name')->nullable();
            $table->string('disk')->nullable();
            $table->string('path')->nullable();
            $table->datetime('converted_for_downloading_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
