<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        // DB::unprepared('CREATE TRIGGER masuk AFTER INSERT ON `transaksis` FOR EACH ROW
        // BEGIN
        //    UPDATE barangs SET barangs.stock = barangs.stock + NEW.masuk WHERE barangs.id = NEW.id_barang;
        // END');
        // DB::unprepared('CREATE TRIGGER keluar AFTER INSERT ON `transaksis` FOR EACH ROW
        // BEGIN
        // UPDATE barangs SET barangs.stock = barangs.stock - NEW.keluar WHERE barangs.id = NEW.id_barang;    
        // UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.keluar WHERE barang_projects.id_project = NEW.id_project AND barang_projects.id_barang = NEW.id_barang;
        // END');
        // DB::unprepared('CREATE TRIGGER masuk_update AFTER UPDATE ON `transaksis` FOR EACH ROW
        // BEGIN
        //    UPDATE barangs SET barangs.stock = barangs.stock - old.masuk + NEW.masuk WHERE barangs.id = NEW.id_barang;
        // END');
        // DB::unprepared('CREATE TRIGGER keluar_update AFTER UPDATE ON `transaksis` FOR EACH ROW
        // BEGIN
        // UPDATE barangs SET barangs.stock = barangs.stock + old.keluar - NEW.keluar WHERE barangs.id = NEW.id_barang;
        // UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - old.keluar + NEW.keluar WHERE barang_projects.id_project = NEW.id_project AND barang_projects.id_barang = NEW.id_barang;
        // END');
        // DB::unprepared('CREATE TRIGGER masuk_delete AFTER DELETE ON `transaksis` FOR EACH ROW
        // BEGIN
        // UPDATE barangs SET barangs.stock = barangs.stock - OLD.masuk WHERE barangs.id = OLD.id_barang;
        // END');
        // DB::unprepared('CREATE TRIGGER keluar_delete AFTER DELETE ON `transaksis` FOR EACH ROW
        // BEGIN
        // UPDATE barangs SET barangs.stock = barangs.stock + OLD.keluar WHERE barangs.id = OLD.id_barang;
        // END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `masuk`');
        DB::unprepared('DROP TRIGGER `keluar`');
        DB::unprepared('DROP TRIGGER `masuk_update`');
        DB::unprepared('DROP TRIGGER `keluar_update`');
        DB::unprepared('DROP TRIGGER `masuk_delete`');
        DB::unprepared('DROP TRIGGER `keluar_delete`');
    }
};
