<?php

namespace App\Http\Controllers;

use App\Models\Project;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
  
            $datas = Project::all(); 
  
            return Datatables::of($datas, 200)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProject"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                           <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                           <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>';

                        //    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProject cancel" onclick="return false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                        //    <polyline points="3 6 5 6 21 6"></polyline>
                        //    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        //    <line x1="10" y1="11" x2="10" y2="17"></line>
                        //    <line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        if ($request->ajax()) {
  
            $datas = Project::all(); 
  
            return Datatables::of($datas, 200)
                    ->addIndexColumn()
                    // ->addColumn('action', function($row){
   
                    //        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProject"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                    //        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    //        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>';

                    //     //    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProject cancel" onclick="return false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                    //     //    <polyline points="3 6 5 6 21 6"></polyline>
                    //     //    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    //     //    <line x1="10" y1="11" x2="10" y2="17"></line>
                    //     //    <line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
    
                    //         return $btn;
                    // })
                    // ->rawColumns(['action'])
                    ->make(true);
        }
        // $category_name = '';
        $data = [
            'category_name' => 'project',
            'page_name' => 'project',
            'has_scrollspy' => 1,
            'scrollspy_offset' => 100,
            'alt_menu' => 0,
        ];              

        // $datas = Project::all();
        
        return view('projek.index')->with($data);
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
        // $data = $request->validate([
        //     'nama' => 'required'  
        // ]);

        // if(Project::create($data)){
        //     alert()->success('success','data project berhasil di tambahkan');
        //     return redirect('/project');
        // } else {
        //     alert()->error('error','data project gagal di tambahkan');
        //     return redirect('/project');
        // }
        Project::updateOrCreate([
            'id' => $request->id
        ],
        [
            'nama' => $request->nama 
            // 'detail' => $request->detail
        ]);
        return response()->json(['success'=>'Product saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $projek
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $projek
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $projek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'nama' => 'required'   
        ]);

        if(Project::where('id', $project->id)->update($data)){
            return redirect('/project');
        } else {
            alert()->error('error','data project gagal di update');
            return redirect('/project');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $projek
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if(Project::destroy($project->id)){
        //     return redirect('/project');
        // } else {
        //     alert()->error('error','data project gagal di hapus');
        //     return redirect('/project');
        // }
        Project::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
