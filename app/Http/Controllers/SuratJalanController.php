<?php

namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\Barang;
use App\Models\NamaBarang;
use App\Models\Project;
use App\Models\BarangProject;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;


class SuratJalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $category_name = '';
        $data = [
            'history' => false,
            'category_name' => 'suratJalan',
            'page_name' => 'suratJalan',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];

        return view('suratjalan.index', [
            'data' => SuratJalan::where('created_at', '>=', Carbon::today())->latest()->get(),
            'barangs' => Barang::all(),
            'projects' => Project::all(),
        ])->with($data);
    }

    public function history()
    {
        $data = [
            'history' => true,
            'category_name' => 'suratJalan',
            'page_name' => 'suratJalan',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];

        return view('suratjalan.index', [
            'su' => SuratJalan::latest()->get(),
            'barngs' => Barang::all(),
            'pros' => Project::all(),
        ])->with($data);
    }

    public function cetak()
    {
        $data = [
            'history' => true,
            'category_name' => 'suratJalan',
            'page_name' => 'suratJalan',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];

        return view('suratjalan.cetak', [
            'su' => SuratJalan::latest()->get(),
            'barngs' => Barang::all(),
            'pros' => Project::all(),
        ])->with($data);
    }

    public function barang(Request $request)
    {
        $data['barang'] = BarangProject::with(['barang.namaBarang'])->where("id_project", $request->id_project)->get();
        return response()->json($data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SuratJalan  $suratJalan
     * @return \Illuminate\Http\Response
     */
    public function show(SuratJalan $suratJalan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuratJalan  $suratJalan
     * @return \Illuminate\Http\Response
     */
    public function edit(SuratJalan $suratJalan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SuratJalan  $suratJalan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SuratJalan $suratJalan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SuratJalan  $suratJalan
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuratJalan $suratJalan)
    {
        //
    }
}
