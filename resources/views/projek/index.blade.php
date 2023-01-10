@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div>
                        <!-- Tambah Data -->
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
                                        <h5 class="modal-title" id="title">Create New Projek</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('projek.store') }}" id="addUser">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput2">Projek Name</label>
                                                <input value="{{ old('nama') }}" required name="nama"
                                                    type="text" required class="form-control" id="nama">
                                            </div>
                                            <div class="input-group">
                                                <button class="btn btn-primary" onClick="store()">Create</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END TAMBAH DATA -->
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                            <thead>
                                <tr align="center">
                                    <th>No</th>
                                    <th>Projek Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $item)
                                    <tr align="center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>                                    
                                                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal"
                                                    data-target="#modalEditData{{$item->id}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit">
                                                        <path
                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                        </path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                        </path>
                                                    </svg>
                                                </button>                                                
                                                <!-- HAPUS DATA -->
                                                <form action="/projek/{{ $item->id }}" method="POST" class="d-inline">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Sure?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-trash-2">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path
                                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                            </path>
                                                            <line x1="10" y1="11" x2="10"
                                                                y2="17"></line>
                                                            <line x1="14" y1="11" x2="14"
                                                                y2="17"></line>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <!-- END HAPUS DATA -->                                      
                                        </td>
                                    </tr>
                                    
                                    <!-- MODAL EDIT DATA -->
                                    <div class="modal fade" id="modalEditData{{$item->id}}" tabindex="-1"
                                    aria-labelledby="modalEditBarang" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="title">Edit Projek
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="/projek/{{ $item->id }}"
                                                    id="addUser">
                                                    @csrf
                                                    @method('put')
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput2">Projek Name</label>
                                                        <input value="{{ old('nama', $item->nama) }}" required
                                                            name="nama" type="text" required
                                                            class="form-control" id="nama">
                                                    </div>                                            
                                                    <div class="input-group">
                                                        <button class="btn btn-primary"
                                                            onClick="store()">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT DATA -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
