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
        Schema::create('transaksi_projects', function (Blueprint $table) {
            $table->id();        
            $table->integer('id_nama_barang');
            $table->integer('id_project');
            $table->integer('masuk');
            $table->integer('keluar');
            $table->integer('stock');
            $table->string('keterangan');
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
        Schema::dropIfExists('transaksi_projects');
    }
};
