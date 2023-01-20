<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\NamaBarang;
use App\Models\Project;
use App\Models\BarangProject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
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
            'category_name' => 'transaksis',
            'page_name' => 'transaksi',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];

        return view('transaksi.index', [
            'trans' => Transaksi::where('created_at', '>=', Carbon::today())->latest()->get(),
            // 'trans' => Transaksi::all(),
            'barngs' => Barang::all(),
            'pros' => Project::all(),
        ])->with($data);
    }

    public function history()
    {
        $data = [
            'history' => true,
            'category_name' => 'transaksis',
            'page_name' => 'transaksi',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];

        return view('transaksi.index', [
            'trans' => Transaksi::latest()->get(),
            'barngs' => Barang::all(),
            'pros' => Project::all(),
        ])->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function barang(Request $request)
    {
        if ($request->id_project) {
            $data['barang'] = BarangProject::with(['barang', 'barang.namaBarang'])->where("id_project", $request->id_project)->where('stock', '>', 0)->get();
        } else {
            $data['barang'] = Barang::with(['namaBarang'])->where('stock', '>', 0)->get();
        }
        return response()->json($data);
    }

    public function data()
    {

        // $data['barang'] = BarangProject::with(['barang', 'barang.namaBarang'])->where("id_project", $request->id_project)->where('stock', '>', 0)->get();            

        $data['barang'] = Barang::with(['namaBarang'])->where('stock', '>', 0)->get();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        // return $request->all();     

        $barang = Barang::all()->where('id', $request->id_barang)->first();
        // return $barang->stock;
        if ($request->masuk > 0) {
            $stok_transaksi = $barang->stock + $request->masuk;
        } else {
            $stok_transaksi = $barang->stock - $request->keluar;
        }

        $data_transaksi = [
            'id_barang'    => $request->id_barang,
            'dari' => $request->dari,
            'ke' => $request->ke,
            'code_project' => $request->code_project,
            'masuk'   => $request->masuk,
            'keluar'     => $request->keluar,
            'stock' => $stok_transaksi,
            'keterangan'        => $request->keterangan,
            'remark'   => $request->remark
        ];

        if ($request->dari != null  && $request->ke != null) {
            // cek apakah ada record barangproject where id project = dari
            if (BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first()) {
                // cek apakah ada record barangproject where id project = ke
                if (BarangProject::all()->where('id_project', $request->ke)->where('id_barang', $request->id_barang)->first()) {
                    Transaksi::create($data_transaksi);
                    return redirect("/transaksi");
                } else {
                    $data_barang_project_ke = [
                        'code_project' => $request->code_project,
                        'id_project' => $request->ke,
                        'id_barang' => $request->id_barang,
                        'stock'     => 0,
                    ];

                    BarangProject::create($data_barang_project_ke);

                    Transaksi::create($data_transaksi);
                    return redirect("/transaksi");
                }
            } else {
                $data_barang_project_dari = [
                    'code_project' => $request->code_project,
                    'id_project' => $request->dari,
                    'id_barang' => $request->id_barang,
                    'stock'     => 0,
                ];

                BarangProject::create($data_barang_project_dari);

                // cek apakah ada record barangproject where id project = ke
                if (BarangProject::all()->where('id_project', $request->ke)->where('id_barang', $request->id_barang)->first()) {
                    Transaksi::create($data_transaksi);
                    return redirect("/transaksi");
                } else {
                    $data_barang_project_ke = [
                        'code_project' => $request->code_project,
                        'id_project' => $request->ke,
                        'id_barang' => $request->id_barang,
                        'stock'     => 0,
                    ];

                    BarangProject::create($data_barang_project_ke);

                    Transaksi::create($data_transaksi);
                    return redirect("/transaksi");
                }
            }
        } else if ($request->dari != null && $request->ke == null) {
            // cek apakah ada record barangproject where id project = dari
            if (BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first()) {
                Transaksi::create($data_transaksi);
                return redirect("/transaksi");
            } else {
                $data_barang_project_dari = [
                    'code_project' => $request->code_project,
                    'id_project' => $request->dari,
                    'id_barang' => $request->id_barang,
                    'stock'     => 0,
                ];
                BarangProject::create($data_barang_project_dari);

                Transaksi::create($data_transaksi);
                return redirect("/transaksi");
            }
        } else if ($request->dari == null && $request->ke != null) {
            // cek apakah ada record barangproject where id project = ke
            if (BarangProject::all()->where('id_project', $request->ke)->where('id_barang', $request->id_barang)->first()) {
                Transaksi::create($data_transaksi);
                return redirect("/transaksi");
            } else {
                $data_barang_project_ke = [
                    'code_project' => $request->code_project,
                    'id_project' => $request->ke,
                    'id_barang' => $request->id_barang,
                    'stock'     => 0,
                ];

                BarangProject::create($data_barang_project_ke);

                Transaksi::create($data_transaksi);
                return redirect("/transaksi");
            }
        } else {
            Transaksi::create($data_transaksi);
            return redirect("/transaksi");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $validateData = $request->validate([
            'tgl'    => 'required',
            'id_barang'    => 'required',
            'masuk'   => 'required',
            'keluar'     => 'required',
            'keterangan'        => 'required',
            'remark'   => 'required'
        ]);
        if (Transaksi::where('id', $transaksi->id)->update($validateData)) {
            return redirect('transaksi');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        Transaksi::destroy($transaksi->id);
        return redirect('/transaksi');
    }
}
