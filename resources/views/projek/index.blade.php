@extends('layouts.app')

@section('content')

@include('sweetalert::alert')

    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div>
                        @if(auth()->user()->role == 'admin')
                        <!-- Tambah Data -->
                        <button type="button" class="btn btn-primary mb-1" id="btnShowFormMaster">
                            <!-- <i class='bx bx-plus-medical'></i> -->
                            Tambah Data
                        </button>
                        @endif

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
                                        <form id="addUser">
                                            {{-- @csrf --}}
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput2">Projek Name</label>
                                                <input type="hidden" name="id" id="id">
                                                <input value="{{ old('nama') }}" required name="nama"
                                                    type="text" required class="form-control" id="nama">
                                            </div>
                                            <div class="input-group">
                                                {{-- <button class="btn btn-primary" id="btnCreate" value="create">Edit</button> --}}
                                                <input type="button" value="" class="btn btn-primary tambah" id="btnCreate" value="create">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END TAMBAH DATA -->
                    </div>
                    @if(auth()->user()->role == 'admin')
                    <div class="table-responsive mb-4 mt-4">
                        <table id="tblMaster" class="table table-hover non-hover data-table" style="width:100%">
                            <thead>
                                <tr align="center">
                                    <th>No</th>
                                    <th>Projek Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                {{-- @foreach ($datas as $item)
                                    <tr align="center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        @if(auth()->user()->role == 'admin')
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
                                                <form action="/project/{{ $item->id }}" method="POST" class="d-inline delete">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm warning cancel" onclick="return false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </button>
                                            </form>
                                            <!-- END HAPUS DATA -->                                    
                                        </td>
                                        @endif
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
                                                <form method="POST" action="/project/{{ $item->id }}"
                                                    id="addUser" class="update">
                                                    @csrf
                                                    @method('put')
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput2">Projek Name</label>
                                                        <input value="{{ old('nama', $item->nama) }}" required
                                                            name="nama" type="text" required
                                                            class="form-control" id="nama">
                                                    </div>                                            
                                                    <div class="input-group">
                                                        <button class="btn btn-primary warning confirm"
                                                            onclick="return false">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT DATA -->
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="table-responsive mb-4 mt-4">
                        <table id="tblMaster" class="table table-hover non-hover data-tableuser" style="width:100%">
                            <thead>
                                <tr align="center">
                                    <th>No</th>
                                    <th>Projek Name</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                {{-- @foreach ($datas as $item)
                                    <tr align="center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        @if(auth()->user()->role == 'admin')
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
                                                <form action="/project/{{ $item->id }}" method="POST" class="d-inline delete">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm warning cancel" onclick="return false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </button>
                                            </form>
                                            <!-- END HAPUS DATA -->                                    
                                        </td>
                                        @endif
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
                                                <form method="POST" action="/project/{{ $item->id }}"
                                                    id="addUser" class="update">
                                                    @csrf
                                                    @method('put')
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput2">Projek Name</label>
                                                        <input value="{{ old('nama', $item->nama) }}" required
                                                            name="nama" type="text" required
                                                            class="form-control" id="nama">
                                                    </div>                                            
                                                    <div class="input-group">
                                                        <button class="btn btn-primary warning confirm"
                                                            onclick="return false">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END EDIT DATA -->
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
@endsection
