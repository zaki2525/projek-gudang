<?php

namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\Barang;
use App\Models\NamaBarang;
use App\Models\Project;
use App\Models\BarangProject;
use App\Models\SuratJalanItem;
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
            'data' => SuratJalan::latest()->get(),
            'barngs' => Barang::all(),
            'projects' => Project::all(),
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
        $data['barang'] = Barang::with(['namaBarang'])->get();
        return response()->json($data);
    }

    public function data()
    {
        $barang = new BarangProject();
        $data['barang'] = BarangProject::with(['barang', 'barang.namaBarang'])->where("id_project", 1)->get();
        // $data = $barang->get();
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
        $barangproject = BarangProject::where('id_project', $request->id_project)->where('id_barang', $request->id_barang)->first();
        // return $request->all();
        $data_surat_jalan = $request->validate([
            'id_project' => ['required'],
            'delivery' => ['required'],
            'kepada' => ['required'],
            'no_sj' => ['required'],
            'no_mobil' => ['required'],
        ]);

        foreach ($request->keluar as $key => $keluar) {
            if ($keluar[$key] <= $barangproject->stock) {
            } else if ($keluar[$key] > $barangproject->stock ){
                alert()->error('Error', 'Barang yang akan dikeluarkan melebihi Stock yang ada saat ini!!');
                return redirect('/suratjalan');
            } else {
                alert()->error('Error', 'Stock Barang Habis!!');
                return redirect('/suratjalan');
            }
        }

        if ($surat_jalan = SuratJalan::create($data_surat_jalan)) {
            foreach ($request->id_barang as $key => $id_barang) {
                $data_surat_jalan_items = [
                    'id_surat_jalan' => $surat_jalan->id,
                    'id_barang' => $id_barang,
                    'id_project' => $request->id_project,
                    'keluar' => $request->keluar[$key],
                    'remark' => $request->remark[$key],
                ];
                SuratJalanItem::create($data_surat_jalan_items);
            }
            alert()->success('success', 'Surat Jalan berhasil di tambahkan');
            return redirect('/suratjalan');
        } else {
            alert()->error('Error', 'Surat Jalan gagal di tambahkan');
            return redirect('/suratjalan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SuratJalan  $suratJalan
     * @return \Illuminate\Http\Response
     */
    public function show(SuratJalan $suratjalan)
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
            'surat_jalan' => $suratjalan,
            'surat_jalan_items' => SuratJalanItem::where('id_surat_jalan', $suratjalan->id)->get(),
            'barngs' => Barang::all(),
            'pros' => Project::all(),
        ])->with($data);
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
