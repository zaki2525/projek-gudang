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
                                <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahBarang" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="title">Create New Transaksi</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('transaksi.store') }}" id="addTransaksi">
                                                    @csrf
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput2">Tanggal</label>
                                                        <input type="date" value="{{ old('tgl') }}" name="tgl" id="date-picker" required class="form-control">
                                                        <script>
                                                            var date = new Date();
                                                            var year = date.getFullYear();
                                                            var month = String(date.getMonth()+1).padStart(2,'0');
                                                            var todayDate = String(date.getDate()).padStart(2,'0');
                                                            var datePattern = year + '-' + month + '-' + todayDate;
                                                            document.getElementById("date-picker").value = datePattern;
                                                        </script>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput6">Material Name</label>
                                                        <select name="id_barang" id="id_barang" class="form-control">
                                                        @foreach ($barngs as $bar)
                                                            <option value="{{ $bar->id }}">{{ $bar->material_name }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput4">Stock In</label>
                                                        <input value="{{ old('masuk') }}" required name="masuk" type="number" required class="form-control" id="masuk">
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput5">Stock Out</label>
                                                        <input value="{{ old('keluar') }}" required name="keluar" type="number" required class="form-control" id="keluar">
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput5">Keterangan</label>
                                                        <input value="{{ old('keterangan') }}" required name="keterangan" type="text" required class="form-control" id="keterangan">
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput5">Remarks</label>
                                                        <input value="{{ old('remark') }}" required name="remark" type="text" required class="form-control" id="remark">
                                                    </div>
                                                    
                                                    <div class="input-group">
                                                        <button class="btn btn-primary" >Create</button>
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
                                            <td>{{ $item->barang->material_name }}</td>
                                            <td>{{ $item->barang->unit }}</td> 
                                            <td>{{ $item->masuk }}</td>
                                            <td>{{ $item->keluar }}</td>
                                            <td>{{ $item->barang->stock }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>{{ $item->remark }}</td>
                                            <td>
                                                <!-- EDIT DATA -->
                                                <a href="#modalEditData{{ $item->id }}" class="edit" data-toggle="modal">
                                                    <i class='bx bxs-edit-alt'></i>
                                                </a>
                                                <!-- END EDIT DATA -->
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