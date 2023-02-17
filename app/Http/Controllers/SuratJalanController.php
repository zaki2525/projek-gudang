<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\SuratJalan;
use App\Models\Barang;
use App\Models\NamaBarang;
use App\Models\Project;
use App\Models\BarangProject;
use App\Models\SuratJalanItem;
use App\Models\Kop;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Yajra\DataTables\DataTables;

class SuratJalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = SuratJalan::where('created_at', '>=', Carbon::today())->with(['project'])->latest()->get();

            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/suratjalan/' . $row->id . '">
                    <button type="button" class="btn btn-primary mb-1">
                        <!-- <i class="bx bx-plus-medical"></i> -->
                        Cetak
                    </button>
                    </a>';
                    $btn = $btn . '<button type="button" class="edit btn btn-dark btn-sm editSuratJalan" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit">
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
            'kops' =>  Kop::all(),
        ])->with($data);
    }

    public function history(Request $request)
    {
        if ($request->ajax()) {
            $datas = SuratJalan::with(['project'])->latest()->get();

            return DataTables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/suratjalan/' . $row->id . '">
                    <button type="button" class="btn btn-primary mb-1">
                        <!-- <i class="bx bx-plus-medical"></i> -->
                        Cetak
                    </button>
                    </a>';
                    $btn = $btn . '<button type="button" class="edit btn btn-dark btn-sm editSuratJalan" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit">
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
            'category_name' => 'suratJalan',
            'page_name' => 'suratJalanHistory',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];

        return view('suratjalan.index', [
            'data' => SuratJalan::latest()->get(),
            'barangs' => Barang::all(),
            'projects' => Project::all(),
            'kops' => Kop::all(),
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
            'kop' => Kop::all(),
        ])->with($data);
    }

    public function suratjalanitem($id)
    {
        $data = SuratJalanItem::where('id_surat_jalan', $id)->with(['barang'])->get();
        return response()->json($data);
    }

    public function barang()
    {
        $data = Barang::all();
        return response()->json($data);
    }

    public function data()
    {
        $barang = new BarangProject();
        $data['barang'] = BarangProject::with(['barang', 'barang.namaBarang'])->where("id_project", 1)->get();
        // $data = $barang->get();
        return response()->json($data);
    }

    public function project(Request $request)
    {
        $data = Project::get();
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

        // foreach ($request->keluar as $key => $keluar) {
        //     if ($keluar[$key] <= $barangproject->stock) {
        //     } else if ($keluar[$key] > $barangproject->stock ){
        //         alert()->error('Error', 'Barang yang akan dikeluarkan melebihi Stock yang ada saat ini!!');
        //         return redirect('/suratjalan');
        //     } else {
        //         alert()->error('Error', 'Stock Barang Habis!!');
        //         return redirect('/suratjalan');
        //     }
        // }

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
            // alert()->success('success', 'Surat Jalan berhasil di tambahkan');
            // return redirect('/suratjalan');
            return response()->json(['success' => "Surat jalan has been created."]);
        } else {
            // alert()->error('Error', 'Surat Jalan gagal di tambahkan');
            // return redirect('/suratjalan');
            return response()->json(['warning' => "Surat Jalan can't be created."]);
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
            'kops' => Kop::all(),
        ])->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuratJalan  $suratJalan
     * @return \Illuminate\Http\Response
     */
    public function edit(SuratJalan $suratjalan)
    {
        return response()->json($suratjalan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SuratJalan  $suratJalan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kop $kop)
    {
        // $kop = Kop::all();
        // if($request->foto != null){
        $rules = [
            'id' => 'required',
            'foto' => 'image|file'
        ];

        // return $request;

        $validateData = $request->validate($rules);

        if ($request->file('foto')) {
            //hapus gambar yang lama
            !is_null($kop->foto) && Storage::delete($kop->foto);
            $validateData['foto'] = $request->file('foto')->store('kop');
        }

        Kop::where("id", $request->id)->update($validateData);

        alert()->success('success', 'Kop Surat berhasil di update');
        return redirect("/suratjalan");
    }

    public function update_surat (Request $request, SuratJalan $suratjalan)
    {
        $data_surat_jalan = $request->validate([
            'id_project' => ['required'],
            'delivery' => ['required'],
            'kepada' => ['required'],
            'no_sj' => ['required'],
            'no_mobil' => ['required'],
        ]);      
        SuratJalanItem::where('id_surat_jalan', $suratjalan->id)->delete();
        if ($suratjalan->update($data_surat_jalan)) {
            foreach ($request->id_barang as $key => $id_barang) {
                $data_surat_jalan_items = [
                    'id_surat_jalan' => $suratjalan->id,
                    'id_barang' => $id_barang,
                    'id_project' => $request->id_project,
                    'keluar' => $request->keluar[$key],
                    'remark' => $request->remark[$key],
                ];
                SuratJalanItem::create($data_surat_jalan_items);
            }            
            return response()->json(['success' => "Surat jalan has been updated."]);
        } else {      
            return response()->json(['warning' => "Surat Jalan can't be updated."]);
        }
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
