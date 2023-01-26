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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();            
            $table->integer('id_barang');
            $table->string('dari')->nullable(true);
            $table->string('ke')->nullable(true);
            $table->string('code_project')->nullable(true);
            $table->integer('masuk');
            $table->integer('keluar');
            $table->integer('stock');
            $table->string('keterangan')->nullable(true);
            $table->string('remark')->nullable(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
};
