<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategorytypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategorytypes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('subcategory_id');
            $table->string('image')->nullable();
            $table->string('created_by');
            $table->longText('qrcode')->nullable();
            $table->timestamps();

            $table->foreign('subcategory_id')
                ->references('id')
                ->on('subcategories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcategorytypes');
    }
}
