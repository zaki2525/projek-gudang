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
           UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.masuk WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.ke;
        END');
        DB::unprepared('CREATE TRIGGER keluar AFTER INSERT ON `transaksis` FOR EACH ROW
        BEGIN
        IF NEW.dari THEN UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.dari;            
        ELSE UPDATE barangs SET barangs.stock = barangs.stock - NEW.keluar WHERE barangs.id = NEW.id_barang;            
        END IF;

        IF NEW.ke THEN UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.ke;
        END IF;
 

        -- IF NEW.dari = null AND NEW.ke = null THEN
        --     UPDATE barangs SET barangs.stock = barangs.stock - NEW.keluar WHERE barangs.id = NEW.id_barang;
        -- ELSEIF NEW.dari AND NEW.ke = null THEN
        --     UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.dari;
        -- ELSEIF NEW.dari = null AND NEW.ke THEN
        --     UPDATE barangs SET barangs.stock = barangs.stock - NEW.keluar WHERE barangs.id = NEW.id_barang;
        --     UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.ke;
        -- ELSE 
        --     UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.dari;
        --     UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.ke;
        -- END IF;

        -- IF NEW.dari THEN UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - NEW.keluar WHERE barang_projects.id_project = NEW.dari AND barang_projects.id_barang = NEW.id_barang;
        -- ELSE UPDATE barangs SET barangs.stock = barangs.stock - NEW.keluar WHERE barangs.id = NEW.id_barang;        
        -- END IF;

        
        -- UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.keluar WHERE barang_projects.id_project = NEW.ke AND barang_projects.id_barang = NEW.id_barang;
        END');
        DB::unprepared('CREATE TRIGGER masuk_update AFTER UPDATE ON `transaksis` FOR EACH ROW
        BEGIN
           UPDATE barangs SET barangs.stock = barangs.stock - old.masuk + NEW.masuk WHERE barangs.id = NEW.id_barang;
        END');
        DB::unprepared('CREATE TRIGGER keluar_update AFTER UPDATE ON `transaksis` FOR EACH ROW
        BEGIN
        IF OLD.dari THEN UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + OLD.keluar WHERE barang_projects.id_barang = OLD.id_barang AND barang_projects.id_project = OLD.dari;
            IF OLD.ke THEN UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - OLD.keluar WHERE barang_projects.id_barang = OLD.id_barang AND barang_projects.id_project = OLD.ke;
            END IF;
        ELSE UPDATE barangs SET barangs.stock = barangs.stock + OLD.keluar WHERE barangs.id = OLD.id_barang;
            IF OLD.ke THEN UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - OLD.keluar WHERE barang_projects.id_barang = OLD.id_barang AND barang_projects.id_project = OLD.ke;
            END IF;
        END IF;

        IF NEW.dari THEN UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.dari;
            IF NEW.ke THEN UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.ke;
            END IF;
        ELSE UPDATE barangs SET barangs.stock = barangs.stock - NEW.keluar WHERE barangs.id = NEW.id_barang;
            IF NEW.ke THEN UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.ke;
            END IF;
        END IF;        

        -- doesnt work
        -- IF OLD.dari = null AND OLD.ke = null THEN
        --     UPDATE barangs SET barangs.stock = barangs.stock + OLD.keluar WHERE barangs.id = OLD.id_barang;
        -- ELSEIF OLD.dari AND OLD.ke = null THEN
        --     UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + OLD.keluar WHERE barang_projects.id_barang = OLD.id_barang AND barang_projects.id_project = OLD.dari;
        -- ELSEIF OLD.dari = null AND OLD.ke THEN
        --     UPDATE barangs SET barangs.stock = barangs.stock + OLD.keluar WHERE barangs.id = OLD.id_barang;
        --     UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - OLD.keluar WHERE barang_projects.id_barang = OLD.id_barang AND barang_projects.id_project = OLD.ke;
        -- ELSE
        --     UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + OLD.keluar WHERE barang_projects.id_barang = OLD.id_barang AND barang_projects.id_project = OLD.dari;
        --     UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - OLD.keluar WHERE barang_projects.id_barang = OLD.id_barang AND barang_projects.id_project = OLD.ke;
        -- END IF;

        --     IF NEW.dari = null AND NEW.ke = null THEN
        --     UPDATE barangs SET barangs.stock = barangs.stock - NEW.keluar WHERE barangs.id = NEW.id_barang;
        -- ELSEIF NEW.dari AND NEW.ke = null THEN
        --     UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.dari;
        -- ELSEIF NEW.dari = null AND NEW.ke THEN
        --     UPDATE barangs SET barangs.stock = barangs.stock - NEW.keluar WHERE barangs.id = NEW.id_barang;
        --     UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.ke;
        -- ELSE
        --     UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.dari;
        --     UPDATE barang_projects SET barang_projects.stock = barang_projects.stock + NEW.keluar WHERE barang_projects.id_barang = NEW.id_barang AND barang_projects.id_project = NEW.ke;
        -- END IF;
        END');
        DB::unprepared('CREATE TRIGGER masuk_delete AFTER DELETE ON `transaksis` FOR EACH ROW
        BEGIN
        UPDATE barangs SET barangs.stock = barangs.stock - OLD.masuk WHERE barangs.id = OLD.id_barang;
        END');
        DB::unprepared('CREATE TRIGGER keluar_delete AFTER DELETE ON `transaksis` FOR EACH ROW
        BEGIN
        UPDATE barangs SET barangs.stock = barangs.stock + OLD.keluar WHERE barangs.id = OLD.id_barang;
        END');
        // DB::unprepared('CREATE TRIGGER keluar_surat AFTER INSERT ON `surat_jalan_items` FOR EACH ROW
        // BEGIN
        // UPDATE barang_projects SET barang_projects.stock = barang_projects.stock - NEW.keluar WHERE barang_projects.id_project = NEW.id_project AND barang_projects.id_barang = NEW.id_barang;
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
        // DB::unprepared('DROP TRIGGER `keluar_surat`');
    }
};
