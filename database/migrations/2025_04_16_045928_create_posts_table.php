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
        Schema::create('tbl_posts', function (Blueprint $table) {
            $table->id('post_id');
            $table->string('post_title');
            $table->string('post_slug')->unique();
            $table->text('post_desc')->nullable();
            $table->longText('post_content');
            $table->string('post_image')->nullable();
            $table->unsignedBigInteger('cate_post_id'); // Liên kết với danh mục bài viết
            $table->boolean('post_status')->default(1); // 1: Hiển thị, 0: Ẩn
            $table->timestamps();
    
            $table->foreign('cate_post_id')->references('cate_post_id')->on('cate_posts')->onDelete('cascade');
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
