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
        //
        Schema::create('roles' , function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // store defualt roles
        DB::insert(
            "INSERT INTO roles (id , name) 
            VALUES (0 , 'user') , (1 , 'seller') , (2 , 'admin') , (3 , 'superuser')"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('roles');
    }
};
