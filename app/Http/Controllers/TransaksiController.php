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
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $category_name = '';
        $data = [
            'category_name' => 'transaksis',
            'page_name' => 'transaksi',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];              
        
        return view('transaksi.history', [           
            'trans' => Transaksi::latest()->get(),
            'barngs' => Barang::all(),
            'pros' => Project::all(),
        ])->with($data);
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
        if($request->masuk > 0){
            $stok_transaksi = $barang->stock + $request->masuk;
        } else {
            $stok_transaksi = $barang->stock - $request->keluar;
        }   
        
        $data_transaksi = [
            'id_barang'    => $request->id_barang,
            'id_project' => $request->id_project,
            'code_project' => $request->code_project, 
            'masuk'   => $request->masuk,
            'keluar'     => $request->keluar,
            'stock' => $stok_transaksi,               
            'keterangan'        => $request->keterangan,
            'remark'   => $request->remark
        ];

        if ($request->id_project != null){
            if(BarangProject::all()->where('id_project', $request->id_project)->where('id_barang', $request->id_barang)->first()){
                                            
                Transaksi::create($data_transaksi);
                            
                return redirect("/transaksi");
            } else {
                $data_barang_project = [
                    'code_project' => $request->code_project, 
                    'id_project' => $request->id_project,
                    'id_barang' => $request->id_barang,
                    'stock'     => 0,
                ];
                BarangProject::create($data_barang_project);                 
                                
                Transaksi::create($data_transaksi);
                            
                return redirect("/transaksi");
            }       
        } else {
            $data_transaksi = [
                'id_barang'    => $request->id_barang,
                'id_project' => $request->id_project,
                'code_project' => $request->code_project, 
                'masuk'   => $request->masuk,
                'keluar'     => $request->keluar,
                'stock' => $stok_transaksi,
                'keterangan'        => $request->keterangan,
                'remark'   => $request->remark
            ];
            // return $validateData;
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
        if(Transaksi::where('id', $transaksi->id)->update($validateData)){
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
