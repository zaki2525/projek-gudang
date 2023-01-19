@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div>
                        {{-- <!-- Tambah Data -->
                        <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#modalTambahData">
                            <!-- <i class='bx bx-plus-medical'></i> -->
                            Tambah Data
                        </button>

                        <!-- MODAL TAMBAH DATA -->
                        <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahBarang"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="title">Create New Barang</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('barang.store') }}" id="addUser">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput2">Material Name</label>
                                                <input value="{{ old('material_name') }}" required name="material_name"
                                                    type="text" required class="form-control" id="material_name">
                                            </div>
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput4">Unit</label>
                                                <input value="{{ old('unit') }}" required name="unit" type="text"
                                                    required class="form-control" id="unit">
                                            </div>
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput5">Stock</label>
                                                <input value="{{ old('stock') }}" required name="stock" type="number"
                                                    required class="form-control" id="stock">
                                            </div>
                                            <div class="input-group">
                                                <button class="btn btn-primary" onClick="store()">Create</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END TAMBAH DATA --> --}}
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                            <thead>
                                <tr align="center">
                                    <th>No</th>
                                    <th>Project</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $item)
                                    <tr align="center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>
                                            <a href="/bproject/{{ $item->id }}">                                        
                                                <button type="button" class="btn btn-primary btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-eye">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                        <circle cx="12" cy="12" r="3"></circle>
                                                    </svg>
                                                </button>
                                            </a>                                            
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
