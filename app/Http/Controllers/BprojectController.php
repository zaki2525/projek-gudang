<?php

namespace App\Http\Controllers;

use App\Models\BarangProject;
use App\Models\Project;
use Illuminate\Http\Request;

class BprojectController extends Controller
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
            'category_name' => 'bproject',
            'page_name' => 'bproject',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];              
        
        return view('bproject.index', [
            'datas' => Project::all(),            
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
     * @param  \App\Models\BarangProject  $bprojek
     * @return \Illuminate\Http\Response
     */
    public function show(Project $bproject)
    {
        // return $bproject;
        $data = [
            'category_name' => 'bproject',
            'page_name' => 'bproject',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];
        return view('bproject.show', [            
            'bproject' => $bproject,
            'items' => BarangProject::all()->where('id_project', $bproject->id)
        ])->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BarangProject  $bprojek
     * @return \Illuminate\Http\Response
     */
    public function edit(BarangProject $bproject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BarangProject  $bprojek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BarangProject $bproject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BarangProject  $bprojek
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarangProject $bproject)
    {
        if(BarangProject::destroy($bproject->id)){
            return redirect('/bproject');
        }    
    }
}
