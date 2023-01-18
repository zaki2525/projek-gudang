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
        Schema::create('surat_jalan_items', function (Blueprint $table) {
            $table->id();
            $table->integer('id_surat_jalan');
            $table->integer('id_barang');
            $table->integer('id_project');
            $table->integer('keluar');
            $table->string('description');
            $table->string('remark');
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
        Schema::dropIfExists('surat_jalan_items');
    }
};
