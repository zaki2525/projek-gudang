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
use Svg\Tag\Rect;
use Yajra\DataTables\DataTables;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $datas = Transaksi::where('created_at', '>=', Carbon::today())->latest('updated_at')->with(['barang.namaBarang', 'dariproject', 'keproject'])->get();

            return Datatables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProject">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProject cancel" onclick="return false">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
            'trans' => Transaksi::where('created_at', '>=', Carbon::today())->latest('updated_at')->get(),
            // 'trans' => Transaksi::all(),
            'barngs' => Barang::all(),
            'pros' => Project::all(),
        ])->with($data);
    }

    public function history(Request $request)
    {
        if ($request->ajax()) {

            $datas = Transaksi::latest('updated_at')->with(['barang.namaBarang', 'dariproject', 'keproject'])->get();

            return Datatables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProject">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProject cancel" onclick="return false">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data = [
            'history' => true,
            'category_name' => 'transaksis',
            'page_name' => 'transaksi-history',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];

        return view('transaksi.index', [
            'trans' => Transaksi::latest('updated_at')->get(),
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
            // agar saat edit barang yang stocknya 0, tetap muncul di select option
            if ($request->id_barang) {
                $edit = BarangProject::with(['barang', 'barang.namaBarang'])->where("id_project", $request->id_project)->where("id_barang", $request->id_barang)->get();
                $data['barang'] = $data['barang']->merge($edit);
            }
        } else {
            $data['barang'] = Barang::with(['namaBarang'])->where('stock', '>', 0)->get();
            // agar saat edit barang yang stocknya 0, tetap muncul di select option
            if ($request->id_barang) {
                $edit = Barang::with(['namaBarang'])->where("id", $request->id_barang)->get();
                $data['barang'] = $data['barang']->merge($edit);
            }
        }
        return response()->json($data);
    }

    public function data()
    {

        $data['barang'] = BarangProject::with(['barang', 'barang.namaBarang'])->where("id_project", 1)->where('stock', '>', 0)->get();
        $edit = BarangProject::with(['barang', 'barang.namaBarang'])->where("id_project", 1)->where("id_barang", 2)->get();
        $data['barang'] = $data['barang']->merge($edit);

        // $data['barang'] = Barang::with(['namaBarang'])->where('stock', '>', 0)->get();

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
        // cek barang         
        if ($request->dari == null) {
            $barang = Barang::all()->where('id', $request->id_barang)->first();
            if ($request->keluar > $barang->stock) {
                alert()->error('Error', 'Barang habis');
                return redirect('/transaksi');
            }
        } else {
            $barang = BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first();
            if ($request->keluar > $barang->stock) {
                alert()->error('Error', 'Barang habis');
                return redirect('/transaksi');
            }
        }

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
            'remark'   => $request->remark,
            'created_at' => $request->created_at
        ];

        if ($request->dari != null  && $request->ke != null) {
            // cek apakah ada record barangproject where id project = dari
            if (BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first()) {
                // cek apakah ada record barangproject where id project = ke
                if (BarangProject::all()->where('id_project', $request->ke)->where('id_barang', $request->id_barang)->first()) {
                    $transaksi = Transaksi::create($data_transaksi);
                    // update stock di table transaksi
                    $data_stock_transaksi = [
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    alert()->success('success', 'Transaction Barang berhasil di tambahkan');
                    return redirect("/transaksi");
                } else {
                    $data_barang_project_ke = [
                        'code_project' => $request->code_project,
                        'id_project' => $request->ke,
                        'id_barang' => $request->id_barang,
                        'stock'     => 0,
                    ];

                    BarangProject::create($data_barang_project_ke);

                    $transaksi = Transaksi::create($data_transaksi);
                    // update stock di table transaksi
                    $data_stock_transaksi = [
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    alert()->success('success', 'Transaction Barang berhasil di tambahkan');
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
                    $transaksi = Transaksi::create($data_transaksi);
                    // update stock di table transaksi
                    $data_stock_transaksi = [
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    alert()->success('success', 'Transaction Barang berhasil di tambahkan');
                    return redirect("/transaksi");
                } else {
                    $data_barang_project_ke = [
                        'code_project' => $request->code_project,
                        'id_project' => $request->ke,
                        'id_barang' => $request->id_barang,
                        'stock'     => 0,
                    ];

                    BarangProject::create($data_barang_project_ke);

                    $transaksi = Transaksi::create($data_transaksi);
                    // update stock di table transaksi
                    $data_stock_transaksi = [
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    alert()->success('success', 'Transaction Barang berhasil di tambahkan');
                    return redirect("/transaksi");
                }
            }
        } else if ($request->dari != null && $request->ke == null) {
            // cek apakah ada record barangproject where id project = dari
            if (BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first()) {
                $transaksi = Transaksi::create($data_transaksi);
                // update stock di table transaksi
                $data_stock_transaksi = [
                    'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                alert()->success('success', 'Transaction Barang berhasil di tambahkan');
                return redirect("/transaksi");
            } else {
                $data_barang_project_dari = [
                    'code_project' => $request->code_project,
                    'id_project' => $request->dari,
                    'id_barang' => $request->id_barang,
                    'stock'     => 0,
                ];
                BarangProject::create($data_barang_project_dari);

                $transaksi = Transaksi::create($data_transaksi);
                // update stock di table transaksi
                $data_stock_transaksi = [
                    'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                alert()->success('success', 'Transaction Barang berhasil di tambahkan');
                return redirect("/transaksi");
            }
        } else if ($request->dari == null && $request->ke != null) {
            // cek apakah ada record barangproject where id project = ke
            if (BarangProject::all()->where('id_project', $request->ke)->where('id_barang', $request->id_barang)->first()) {
                $transaksi = Transaksi::create($data_transaksi);
                // update stock di table transaksi
                $data_stock_transaksi = [
                    'stock' => (Barang::where('id', $request->id_barang)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                alert()->success('success', 'Transaction Barang berhasil di tambahkan');
                return redirect("/transaksi");
            } else {
                $data_barang_project_ke = [
                    'code_project' => $request->code_project,
                    'id_project' => $request->ke,
                    'id_barang' => $request->id_barang,
                    'stock'     => 0,
                ];

                BarangProject::create($data_barang_project_ke);

                $transaksi = Transaksi::create($data_transaksi);
                // update stock di table transaksi
                $data_stock_transaksi = [
                    'stock' => (Barang::where('id', $request->id_barang)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                alert()->success('success', 'Transaction Barang berhasil di tambahkan');
                return redirect("/transaksi");
            }
        } else {
            $transaksi = Transaksi::create($data_transaksi);
            // update stock di table transaksi
            $data_stock_transaksi = [
                'stock' => (Barang::where('id', $request->id_barang)->first())->stock
            ];
            $transaksi->update($data_stock_transaksi);
            alert()->success('success', 'Transaction Barang berhasil di tambahkan');
            return redirect("/transaksi");
        }
        alert()->error('Error', 'Transaction Barang gagal di tambahkan');
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
        // cek barang         
        if ($request->dari == null) {
            $barang = Barang::all()->where('id', $request->id_barang)->first();
            if ($transaksi->dari == null) {
            } else {
                if ($request->keluar > ($barang->stock + $transaksi->keluar)) {
                    alert()->error('Error', 'Barang habis');
                    return redirect('/transaksi');
                }
            }
        } else {
            $barang = BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first();
            if ($request->keluar > ($barang->stock + $transaksi->keluar)) {
                alert()->error('Error', 'Barang habis');
                return redirect('/transaksi');
            }
        }

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
            'remark'   => $request->remark,
            'created_at' => $request->created_at
        ];

        if ($request->dari != null  && $request->ke != null) {
            // cek apakah ada record barangproject where id project = dari
            if (BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first()) {
                // cek apakah ada record barangproject where id project = ke
                if (BarangProject::all()->where('id_project', $request->ke)->where('id_barang', $request->id_barang)->first()) {
                    $transaksi->update($data_transaksi);
                    // update stock di table transaksi
                    $data_stock_transaksi = [
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    alert()->success('success', 'Transaction Barang berhasil di-update');
                    return redirect("/transaksi");
                } else {
                    $data_barang_project_ke = [
                        'code_project' => $request->code_project,
                        'id_project' => $request->ke,
                        'id_barang' => $request->id_barang,
                        'stock'     => 0,
                    ];

                    BarangProject::create($data_barang_project_ke);

                    $transaksi->update($data_transaksi);
                    // update stock di table transaksi
                    $data_stock_transaksi = [
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    alert()->success('success', 'Transaction Barang berhasil di-update');
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
                    $transaksi->update($data_transaksi);
                    // update stock di table transaksi
                    $data_stock_transaksi = [
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    alert()->success('success', 'Transaction Barang berhasil di-update');
                    return redirect("/transaksi");
                } else {
                    $data_barang_project_ke = [
                        'code_project' => $request->code_project,
                        'id_project' => $request->ke,
                        'id_barang' => $request->id_barang,
                        'stock'     => 0,
                    ];

                    BarangProject::create($data_barang_project_ke);
                    $transaksi->update($data_transaksi);
                    // update stock di table transaksi
                    $data_stock_transaksi = [
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    alert()->success('success', 'Transaction Barang berhasil di-update');
                    return redirect("/transaksi");
                }
            }
        } else if ($request->dari != null && $request->ke == null) {
            // cek apakah ada record barangproject where id project = dari
            if (BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first()) {
                $transaksi->update($data_transaksi);
                // update stock di table transaksi
                $data_stock_transaksi = [
                    'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                alert()->success('success', 'Transaction Barang berhasil di-update');
                return redirect("/transaksi");
            } else {
                $data_barang_project_dari = [
                    'code_project' => $request->code_project,
                    'id_project' => $request->dari,
                    'id_barang' => $request->id_barang,
                    'stock'     => 0,
                ];
                BarangProject::create($data_barang_project_dari);

                $transaksi->update($data_transaksi);
                // update stock di table transaksi
                $data_stock_transaksi = [
                    'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                alert()->success('success', 'Transaction Barang berhasil di-update');
                return redirect("/transaksi");
            }
        } else if ($request->dari == null && $request->ke != null) {
            // cek apakah ada record barangproject where id project = ke
            if (BarangProject::all()->where('id_project', $request->ke)->where('id_barang', $request->id_barang)->first()) {
                $transaksi->update($data_transaksi);
                // update stock di table transaksi
                $data_stock_transaksi = [
                    'stock' => (Barang::where('id', $request->id_barang)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                alert()->success('success', 'Transaction Barang berhasil di-update');
                return redirect("/transaksi");
            } else {
                $data_barang_project_ke = [
                    'code_project' => $request->code_project,
                    'id_project' => $request->ke,
                    'id_barang' => $request->id_barang,
                    'stock'     => 0,
                ];

                BarangProject::create($data_barang_project_ke);

                $transaksi->update($data_transaksi);
                // update stock di table transaksi
                $data_stock_transaksi = [
                    'stock' => (Barang::where('id', $request->id_barang)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                alert()->success('success', 'Transaction Barang berhasil di-update');
                return redirect("/transaksi");
            }
        } else {
            $transaksi->update($data_transaksi);
            // update stock di table transaksi
            $data_stock_transaksi = [
                'stock' => (Barang::where('id', $request->id_barang)->first())->stock
            ];
            $transaksi->update($data_stock_transaksi);
            alert()->success('success', 'Transaction Barang berhasil di-update');
            return redirect("/transaksi");
        }
        alert()->error('Error', 'Transaction Barang gagal di tambahkan');
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
