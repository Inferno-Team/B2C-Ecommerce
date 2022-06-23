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
        Schema::create('billitems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->references('id')->on('bills')->cascadeOnDelete();
            $table->foreignId('prod_id')->nullable()->references('id')->on('products')->nullOnDelete();
            $table->integer('item_count')->default(1);
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
        Schema::dropIfExists('billitems');
    }
};
