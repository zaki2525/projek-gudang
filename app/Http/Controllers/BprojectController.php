<?php

namespace App\Http\Controllers;

use App\Models\Bprojek;
use Illuminate\Http\Request;

class BprojekController extends Controller
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
            'category_name' => 'bprojek',
            'page_name' => 'bprojek',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];              

        $datas = Bprojek::all();
        
        return view('bprojek.index', [
            'datas' => Bprojek::all()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bprojek  $bprojek
     * @return \Illuminate\Http\Response
     */
    public function show(Bprojek $bprojek)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bprojek  $bprojek
     * @return \Illuminate\Http\Response
     */
    public function edit(Bprojek $bprojek)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bprojek  $bprojek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bprojek $bprojek)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bprojek  $bprojek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bprojek $bprojek)
    {
        //
    }
}
