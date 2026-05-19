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
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('userID')->unsigned()->nullable();
            $table->integer('blogID')->unsigned();
            $table->text('text');
            $table->timestamp('time');
            $table->timestamps();

            $table->foreign('userID')->references('id')->on('user')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('blogID')->references('id')->on('blogs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_comments');
    }
};
