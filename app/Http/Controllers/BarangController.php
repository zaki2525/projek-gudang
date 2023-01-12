<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\NamaBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
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
            'category_name' => 'barang',
            'page_name' => 'barang',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];              

        $datas = Barang::all();
        
        return view('barang.index', [
            'datas' => Barang::all()
        ])->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_nama_barang = $request->validate([
            'nama' => 'required',
            'unit' => 'required',           
        ]);

        if($nama_barang = NamaBarang::create($data_nama_barang)){
            $data_barang = [
                'id_nama_barang' => $nama_barang->id,
                // 'stock' => $request->validate(['stock'], ['required'])
                'stock' => 0
            ];    
                if(Barang::create($data_barang)){
                    return redirect('barang');
                }
        }     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NamaBarang $barang)
    {
        $data_nama_barang = $request->validate([
            'nama' => 'required',
            'unit' => 'required',           
        ]);

        if(NamaBarang::where('id', $barang->id)->update($data_nama_barang)){
            return redirect('barang');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        if(Barang::destroy($barang->id)){
            return redirect('barang');
        }
    }
}
