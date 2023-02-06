<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\NamaBarang;
use App\Models\Project;
use App\Models\BarangProject;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'category_name' => 'dashboard',
            'page_name' => 'sales',
            'has_scrollspy' => 0,
            'scrollspy_offset' => '',
            'alt_menu' => 0,
        ];            
        
        return view('dashboard2', [           
            'trans' => Transaksi::latest('updated_at')->get(),
            'barngs' => Barang::all(),
            'pros' => Project::all(),
        ])->with($data);
    }
}
