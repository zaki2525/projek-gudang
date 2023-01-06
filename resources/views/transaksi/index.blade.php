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
                                            <th>Tanggal</th>
                                            <th>Material Name</th>
                                            <th>Unit</th>
                                            <th>In</th>
                                            <th>Out</th>
                                            <th>Stock</th>
                                            <th>Keterangan</th>
                                            <th>Remarks</th>                                                                                    
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trans as $item)                                     
                                        <tr align="center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->tgl }}</td>
                                            <td>{{ $item->material_name }}</td>
                                            <td>{{ $item->unit }}</td> 
                                            <td>{{ $item->masuk }}</td>
                                            <td>{{ $item->keluar }}</td>
                                            <td>{{ $item->stock }}</td>
                                            <td>{{ $item->Keterangan }}</td>
                                            <td>{{ $item->remark }}</td>
                                            <td>
                                                <!-- EDIT DATA -->
                                                <a href="#modalEditData{{ $use->id }}" class="edit" data-toggle="modal">
                                                    <i class='bx bxs-edit-alt'></i>
                                                </a>
                                                <!-- END EDIT DATA -->
                                            </td>                             
                                            {{-- <td> 
                                                <div class="d-flex">
                                                    <div class="usr-img-frame mr-2 rounded-circle">
                                                        <img alt="avatar" class="img-fluid rounded-circle" src="{{asset('storage/img/90x90.jpg')}}">
                                                    </div>
                                                </div>
                                            </td> --}}
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-dark btn-sm">Open</button>
                                                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference3">
                                                      <a class="dropdown-item" href="#">Action</a>
                                                      <a class="dropdown-item" href="#">Another action</a>
                                                      <a class="dropdown-item" href="#">Something else here</a>
                                                      <div class="dropdown-divider"></div>
                                                      <a class="dropdown-item" href="#">Separated link</a>
                                                    </div>
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