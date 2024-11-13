<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentBlocksTable extends Migration
{
    public function up()
    {
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('section'); // e.g., 'hero', 'about', 'consultation'
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->string('image_path')->nullable(); // URL or path to the image
            $table->string('button_text')->nullable();
             $table->string('phone_number')->nullable(); // New column for phone number
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('content_blocks');
    }
}
