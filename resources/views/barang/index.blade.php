@extends('layouts.app')

@section('content')

            <div class="layout-px-spacing">
                
                <div class="row layout-top-spacing">
                
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="widget-content widget-content-area br-6">
                            <div class="table-responsive mb-4 mt-4">
                                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                                    <thead>
                                        <tr align="center">
                                            <th>No</th>
                                            <th>Material Name</th>
                                            <th>Unit</th>
                                            <th>Stock</th>                                                                                    
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $item)                                     
                                        <tr align="center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->material_name }}</td>
                                            <td>{{ $item->unit }}</td> 
                                            <td>{{ $item->stock }}</td>                             
                                            {{-- <td> 
                                                <div class="d-flex">
                                                    <div class="usr-img-frame mr-2 rounded-circle">
                                                        <img alt="avatar" class="img-fluid rounded-circle" src="{{asset('storage/img/90x90.jpg')}}">
                                                    </div>
                                                </div>
                                            </td> --}}
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-dark btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                    </button>                                                                                                        
                                                  </div>
                                            </td>
                                        </tr>
                                        @endforeach                                                                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
           
@endsection