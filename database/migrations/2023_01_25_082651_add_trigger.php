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
        DB::unprepared('CREATE TRIGGER masuk AFTER INSERT ON `transaksis` FOR EACH ROW
        BEGIN
            IF NEW.dari IS NULL AND NEW.ke THEN
                UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.masuk WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.ke;
            END IF;
        END');
        DB::unprepared('CREATE TRIGGER keluar AFTER INSERT ON `transaksis` FOR EACH ROW
        BEGIN
        IF NEW.dari THEN 
            UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.dari;                                            
        END IF;

        IF NEW.ke THEN
            UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.ke;
        END IF;
        END');
        DB::unprepared('CREATE TRIGGER masuk_update AFTER UPDATE ON `transaksis` FOR EACH ROW
        BEGIN
        IF NEW.dari IS NULL AND NEW.ke THEN
            UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - OLD.masuk WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = OLD.ke;
            UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.masuk WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.ke;
        END IF;           
        END');
        DB::unprepared('CREATE TRIGGER keluar_update AFTER UPDATE ON `transaksis` FOR EACH ROW
        BEGIN
        IF OLD.dari THEN 
            UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + OLD.keluar WHERE barang_projects.id_barang = OLD.id_barang AND barang_projects.id_project = OLD.dari;                                            
        END IF;

        IF NEW.dari THEN 
            UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.dari;                                            
        END IF;

        IF OLD.ke THEN
            UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - OLD.keluar WHERE barang_projects.id_barang = OLD.id_barang AND barang_projects.id_project = OLD.ke;
        END IF;

        IF NEW.ke THEN
            UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.ke;
        END IF;        
        END');       
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
        // DB::unprepared('DROP TRIGGER `keluar_surat`');
    }
};
