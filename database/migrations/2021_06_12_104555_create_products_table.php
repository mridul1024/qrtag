<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('subcategorytype_id');
            $table->string('material_id')->unique();
            $table->text('qrcode')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('status');
            $table->text('rejectinfo')->nullable();
            $table->string('created_by');
            $table->timestamps();

            $table->foreign('subcategorytype_id')
                ->references('id')
                ->on('subcategorytypes')
                ->onDelete('cascade');

            $table->foreign('job_id')
                ->references('id')
                ->on('jobs')
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
        Schema::dropIfExists('products');
    }
}
