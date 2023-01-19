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

        NamaBarang::create([
            'nama' => 'Baut',
            'unit' => 'pcs'
        ]);

        NamaBarang::create([
            'nama' => 'Baterai',
            'unit' => 'pcs',
        ]);

        NamaBarang::create([
            'nama' => 'Kabel Lan',
            'unit' => 'meter',
        ]);

        Barang::create([
            'id_nama_barang' => '1',
            'stock' => '50',
        ]);
        Barang::create([
            'id_nama_barang' => '2',
            'stock' => '110',
        ]);
        Barang::create([
            'id_nama_barang' => '3',
            'stock' => '200',
        ]);

        Project::create([
            'nama' => 'Lampung',
        ]);

        Project::create([
            'nama' => 'Bojonggede',
        ]);

        Transaksi::create([
            'id_barang' => '1',
            'id_project' => '1',
            'code_project' => 'TGR',
            'masuk' => '0',
            'keluar' => '2',
            'stock' => '48',
            'keterangan' => '-',
            'remark' => '-'
        ]);

        Transaksi::create([
            'id_barang' => '2',
            'id_project' => '1',
            'code_project' => 'TGR',
            'masuk' => '0',
            'keluar' => '10',
            'stock' => '110',
            'keterangan' => '-',
            'remark' => '-'
        ]);

        BarangProject::create([
            'code_project' => 'TGR',
            'id_barang' => '1',
            'id_project' => '1',
            'stock' => '2',
        ]);

        BarangProject::create([
            'code_project' => 'TGR',
            'id_barang' => '2',
            'id_project' => '1',
            'stock' => '10',
        ]);
    }
}
