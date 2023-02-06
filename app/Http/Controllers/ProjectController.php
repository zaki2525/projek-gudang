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
  
            return Datatables::of($datas)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProject">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProject cancel" onclick="return false">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
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
