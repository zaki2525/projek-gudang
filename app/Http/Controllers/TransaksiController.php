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

            $datas = Transaksi::where('created_at', '>=', Carbon::today())->latest('updated_at')->with(['barang', 'dariproject', 'keproject'])->get();

            return Datatables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<button type="button" class="edit btn btn-dark btn-sm editTransaksi" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-edit">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                        </path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                        </path>
                    </svg>
                    </button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->editColumn('created_at', function ($datas) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $datas->created_at)->format('d-m-Y');
                    return $formatedDate;
                })
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
            'barngs' => Barang::get(),
            'pros' => Project::all(),
        ])->with($data);
    }

    public function history(Request $request)
    {
        if ($request->ajax()) {

            $datas = Transaksi::latest('updated_at')->with(['barang', 'dariproject', 'keproject'])->get();

            return Datatables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<button type="button" class="edit btn btn-dark btn-sm editTransaksi" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-edit">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                        </path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                        </path>
                    </svg>
                    </button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->editColumn('created_at', function ($datas) {
                    $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $datas->created_at)->format('d-m-Y');
                    return $formatedDate;
                })
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
            'barngs' => Barang::get(),
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
            $data['barang'] = BarangProject::with(['barang'])->where("id_project", $request->id_project)->get();
            // agar saat edit barang yang stocknya 0, tetap muncul di select option
            if ($request->id_barang) {
                $edit = BarangProject::with(['barang'])->where("id_project", $request->id_project)->where("id_barang", $request->id_barang)->get();
                $data['barang'] = $data['barang']->merge($edit);
            }
        } else {
            $data['barang'] = Barang::get();
            // agar saat edit barang yang stocknya 0, tetap muncul di select option
            if ($request->id_barang) {
                $edit = Barang::where("id", $request->id_barang)->get();
                $data['barang'] = $data['barang']->merge($edit);
            }
        }
        return response()->json($data);
    }

    public function project(Request $request)
    {
        if ($request->id_barang) {
            $data = BarangProject::with(['project'])->where('id_barang', $request->id_barang)->where('stock', '>', 0)->get();
        } else {
            $data = Project::get();
        }
        return response()->json($data);
    }

    public function data()
    {

        $data['barang'] = BarangProject::with(['barang', 'barang'])->where("id_project", 1)->where('stock', '>', 0)->get();
        $edit = BarangProject::with(['barang', 'barang'])->where("id_project", 1)->where("id_barang", 2)->get();
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
            // $barang = Barang::all()->where('id', $request->id_barang)->first();
            // if ($request->keluar > $barang->stock) {
            //     alert()->error('Error', 'Barang habis');
            //     return redirect('/transaksi');
            // }
        } else {
            $barang = BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first();
            if ($request->keluar > $barang->stock) {
                alert()->error('Error', 'Barang habis');
                return redirect('/transaksi');
            }
        }

        // if ($request->masuk > 0) {
        //     $stok_transaksi = $barang->stock + $request->masuk;
        // } else {
        //     $stok_transaksi = $barang->stock - $request->keluar;
        // }

        $data_transaksi = [
            'id_barang'    => $request->id_barang,
            'dari' => $request->dari,
            'ke' => $request->ke,
            'code_project' => $request->code_project,
            'masuk'   => $request->masuk,
            'keluar'     => $request->keluar,
            'stock' => 0,
            'keterangan'        => $request->keterangan,
            'remark'   => $request->remark,
            'created_at' => $request->created_at
        ];

        if ($request->dari && $request->ke) {
            // cek apakah ada record barangproject where id project = dari
            if (BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first()) {
                // cek apakah ada record barangproject where id project = ke
                if (BarangProject::all()->where('id_project', $request->ke)->where('id_barang', $request->id_barang)->first()) {
                    $transaksi = Transaksi::create($data_transaksi);
                    // update stock di table transaksi
                    $data_stock_transaksi = [
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->ke)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    return response()->json(['success' => 'Transaksi has been created.']);
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
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->ke)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    return response()->json(['success' => 'Transaksi has been created.']);
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
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->ke)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    return response()->json(['success' => 'Transaksi has been created.']);
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
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->ke)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    return response()->json(['success' => 'Transaksi has been created.']);
                }
            }
        } else if ($request->dari && $request->ke == null) {
            // cek apakah ada record barangproject where id project = dari
            if (BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first()) {
                $transaksi = Transaksi::create($data_transaksi);
                // update stock di table transaksi
                $data_stock_transaksi = [
                    'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                return response()->json(['success' => 'Transaksi has been created.']);
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
                return response()->json(['success' => 'Transaksi has been created.']);
            }
            // return response()->json(['warning' => "Transaksi can't be create"]);
        } else if ($request->dari == null && $request->ke) {
            // cek apakah ada record barangproject where id project = ke
            if (BarangProject::all()->where('id_project', $request->ke)->where('id_barang', $request->id_barang)->first()) {
                $transaksi = Transaksi::create($data_transaksi);
                // update stock di table transaksi
                $data_stock_transaksi = [
                    'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->ke)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                return response()->json(['success' => 'Transaksi has been created.']);
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
                    'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->ke)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                return response()->json(['success' => 'Transaksi has been created.']);
            }
        } else {
            // $transaksi = Transaksi::create($data_transaksi);
            // // update stock di table transaksi
            // $data_stock_transaksi = [
            //     'stock' => (Barang::where('id', $request->id_barang)->first())->stock
            // ];
            // $transaksi->update($data_stock_transaksi);
            return response()->json(['warning' => "Transaksi can't be create"]);
            alert()->success('error', "Transaksi can't be create");
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
        return response()->json($transaksi);
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
        // // cek barang         
        // if ($request->dari == null) {
        //     // $barang = Barang::all()->where('id', $request->id_barang)->first();
        //     // if ($transaksi->dari == null) {
        //     // } else {
        //     //     if ($request->keluar > ($barang->stock + $transaksi->keluar)) {
        //     //         alert()->error('Error', 'Barang habis');
        //     //         return redirect('/transaksi');
        //     //     }
        //     // }
        // } else {
        //     $barang = BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first();
        //     if ($request->keluar > ($barang->stock + $transaksi->keluar)) {
        //         alert()->error('Error', 'Barang habis');
        //         return redirect('/transaksi');
        //     }
        // }

        // if ($request->masuk > 0) {
        //     $stok_transaksi = $barang->stock + $request->masuk;
        // } else {
        //     $stok_transaksi = $barang->stock - $request->keluar;
        // }

        $data_transaksi = [
            'id_barang'    => $request->id_barang,
            'dari' => $request->dari,
            'ke' => $request->ke,
            'code_project' => $request->code_project,
            'masuk'   => $request->masuk,
            'keluar'     => $request->keluar,
            'stock' => 0,
            'keterangan'        => $request->keterangan,
            'remark'   => $request->remark,
            'created_at' => $request->created_at
        ];

        if ($request->dari && $request->ke) {
            // cek apakah ada record barangproject where id project = dari
            if (BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first()) {
                // cek apakah ada record barangproject where id project = ke
                if (BarangProject::all()->where('id_project', $request->ke)->where('id_barang', $request->id_barang)->first()) {
                    $transaksi->update($data_transaksi);
                    // update stock di table transaksi
                    $data_stock_transaksi = [
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->ke)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    alert()->success('success', 'Transaction Barang berhasil di-update');
                    // 
                    return response()->json(['success' => 'Transaksi has been updated.']);
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
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->ke)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    alert()->success('success', 'Transaction Barang berhasil di-update');
                    // 
                    return response()->json(['success' => 'Transaksi has been updated.']);
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
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->ke)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    alert()->success('success', 'Transaction Barang berhasil di-update');
                    // 
                    return response()->json(['success' => 'Transaksi has been updated.']);
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
                        'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->ke)->first())->stock
                    ];
                    $transaksi->update($data_stock_transaksi);
                    alert()->success('success', 'Transaction Barang berhasil di-update');
                    // 
                    return response()->json(['success' => 'Transaksi has been updated.']);
                }
            }
        } else if ($request->dari && $request->ke == null) {
            // cek apakah ada record barangproject where id project = dari
            if (BarangProject::all()->where('id_project', $request->dari)->where('id_barang', $request->id_barang)->first()) {
                $transaksi->update($data_transaksi);
                // update stock di table transaksi
                $data_stock_transaksi = [
                    'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->dari)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                alert()->success('success', 'Transaction Barang berhasil di-update');
                // 
                return response()->json(['success' => 'Transaksi has been updated.']);
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
                // 
                return response()->json(['success' => 'Transaksi has been updated.']);
            }
        } else if ($request->dari == null && $request->ke) {
            // cek apakah ada record barangproject where id project = ke
            if (BarangProject::all()->where('id_project', $request->ke)->where('id_barang', $request->id_barang)->first()) {
                $transaksi->update($data_transaksi);
                // update stock di table transaksi
                $data_stock_transaksi = [
                    'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->ke)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                alert()->success('success', 'Transaction Barang berhasil di-update');
                // 
                return response()->json(['success' => 'Transaksi has been updated.']);
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
                    'stock' => (BarangProject::where('id_barang', $request->id_barang)->where('id_project', $request->ke)->first())->stock
                ];
                $transaksi->update($data_stock_transaksi);
                alert()->success('success', 'Transaction Barang berhasil di-update');
                // 
                return response()->json(['success' => 'Transaksi has been updated.']);
            }
        } else {
            // $transaksi->update($data_transaksi);
            // // update stock di table transaksi
            // $data_stock_transaksi = [
            //     'stock' => (Barang::where('id', $request->id_barang)->first())->stock
            // ];
            // $transaksi->update($data_stock_transaksi);
            // alert()->success('success', 'Transaction Barang berhasil di-update');
            // 
            return response()->json(['warning' => "Transaksi can't be updated."]);
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
