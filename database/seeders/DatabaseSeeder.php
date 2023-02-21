<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\BarangProject;
use App\Models\NamaBarang;
use App\Models\Project;
use App\Models\Transaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kop;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => "admin",
            'email' => "admin@cork.com",
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => "user",
            'email' => "user",
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Barang::create([
        //     'nama' => 'Switch Hub HIKVISION 4 Port            ',
        //     'unit' => 'unit'
        // ]);

        // Barang::create([
        //     'nama' => 'Kamera PTZ HIKVISION Speed Dome            ',
        //     'unit' => 'unit',
        // ]);

        // Barang::create([
        //     'nama' => 'Mini Display Port Adapter            ',
        //     'unit' => 'pcs',
        // ]);    

        // Project::create([
        //     'nama' => 'Sentralisasi Minning
        //     ',
        // ]);

        // Project::create([
        //     'nama' => 'Dawuan',
        // ]);

        // Project::create([
        //     'nama' => 'Sentra',
        // ]);

        // Kop::create([
        //     'foto' => 'kop/surat.jpg'
        // ]);


        // Transaksi::create([
        //     'id_barang' => '1',
        //     'dari' => '',
        //     'ke' => '2',
        //     'code_project' => 'TGR',
        //     'masuk' => '0',
        //     'keluar' => '2',
        //     'stock' => '48',
        //     'keterangan' => '-',
        //     'remark' => '-'
        // ]);

        // Transaksi::create([
        //     'id_barang' => '2',
        //     'dari' => '1',
        //     'ke' => '2',
        //     'code_project' => 'TGR',
        //     'masuk' => '0',
        //     'keluar' => '10',
        //     'stock' => '110',
        //     'keterangan' => '-',
        //     'remark' => '-'
        // ]);

        // BarangProject::create([
        //     'code_project' => 'TGR',
        //     'id_barang' => '1',
        //     'id_project' => '1',
        //     'stock' => '2',
        // ]);

        // BarangProject::create([
        //     'code_project' => 'TGR',
        //     'id_barang' => '2',
        //     'id_project' => '1',
        //     'stock' => '10',
        // ]);
    }
}
