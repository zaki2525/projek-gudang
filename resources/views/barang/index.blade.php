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
                        <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#modalTambahData">
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
                                                <input value="{{ old('nama') }}" required name="nama"
                                                    type="text" required class="form-control" id="nama">
                                            </div>
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput4">Unit</label>
                                                <input value="{{ old('unit') }}" required name="unit" type="text"
                                                    required class="form-control" id="unit">
                                            </div>
                                            {{-- <div class="form-floating mb-3">
                                                <label for="floatingInput5">Stock</label>
                                                <input value="{{ old('stock') }}" required name="stock" type="number"
                                                    required class="form-control" id="stock">
                                            </div> --}}
                                            {{-- <div class="form-floating mb-3">
                                                <label for="floatingInput6">Role</label>
                                                <select name="role" id="role" class="form-control">
                                                    <option value="kepala">Kepala</option>
                                                    <option value="subag">Subag</option>
                                                    <option value="verifikator">Verifikator</option>
                                                    <option value="analis">Analis</option>
                                                </select>
                                            </div> --}}
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
                                        <td>{{ $item->namaBarang->nama }}</td>
                                        <td>{{ $item->namaBarang->unit }}</td>
                                        <td>{{ $item->stock + $item->totalBarang() }}</td>
                                        <td>
                                            <a href="/barang/{{ $item->id }}">                                        
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
                                            @if(auth()->user()->role == 'admin')
                                            <button type="button" class="btn btn-dark btn-sm" data-toggle="modal"
                                                data-target="#modalEditData{{ $item->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <!-- HAPUS DATA -->
                                            <form action="/barang/{{ $item->id }}" method="POST" class="d-inline delete">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm warning cancel"
                                                    onclick="return false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-trash-2">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10" y2="17">
                                                        </line>
                                                        <line x1="14" y1="11" x2="14" y2="17">
                                                        </line>
                                                    </svg>
                                                </button>
                                            </form>
                                            <!-- END HAPUS DATA -->
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- MODAL EDIT DATA -->
                                    <div class="modal fade" id="modalEditData{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="modalEditBarang" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="title">Edit Barang
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="barang/{{ $item->id }}"
                                                        id="addUser" class="update">
                                                        @csrf
                                                        @method('put')
                                                        <div class="form-floating mb-3">
                                                            <label for="floatingInput2">Material Name</label>
                                                            <input
                                                                value="{{ old('nama', $item->namaBarang->nama) }}"
                                                                required name="nama" type="text" required
                                                                class="form-control" id="nama">
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <label for="floatingInput4">Unit</label>
                                                            <input value="{{ old('unit', $item->namaBarang->unit) }}" required
                                                                name="unit" type="text" required
                                                                class="form-control" id="unit">
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <label for="floatingInput5">Stock</label>
                                                            <input value="{{ old('stock', $item->stock) }}" disabled
                                                                name="stock" type="number" required
                                                                class="form-control" id="stock">
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
