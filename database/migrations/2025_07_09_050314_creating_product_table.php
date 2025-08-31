<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('products' , function (Blueprint $table){
            $table->id();
            $table->string("name" , 225)->unique();
            $table->text("description");
            $table->bigInteger("price" );
            $table->string("image_url");
            $table->integer("products_count");
            $table->integer("sales_count")->default(0);
            $table->boolean("is_verified")->default(false);
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('products');
    }
};
