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
                                                    <!-- <div class="form-floating mb-3">
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
                                                    </div> -->
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput6">Material Name</label>
                                                        <select name="id_barang" id="id_barang" class="form-control">
                                                        @foreach ($barngs as $bar)
                                                            <option value="{{ $bar->id }}">{{ $bar->namaBarang->nama }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput4">Stock In</label>
                                                        <input value="{{ old('masuk') }}" required name="masuk" type="number" required class="form-control" id="masuk">
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput6">Projek Name</label>
                                                        <select name="id_project" id="id_project" class="form-control">
                                                            <option value="">Default</option>
                                                        @foreach ($pros as $bar)
                                                            <option value="{{ $bar->id }}">{{ $bar->nama }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-floating mb-3 menu" id="code_project" style='display:none'>
                                                        <label for="floatingInput5">Code Projek</label>
                                                        <input value="{{ old('code_project') }}" name="code_project" type="text" class="form-control" id="code_project">
                                                    </div>
                                                    
                                                    <div class="code-container"> 
                                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
                                                    <script>
                                                        
                                                        $('#id_project').on('change', function() {
                                                            // const selected = $(this).find('option:selected');
                                                            const selected = document.getElementById('id_project').value;
                                                            if(selected != '-'){
                                                                document.getElementById('code_project').style.display = "block"
                                                            } else{
                                                                document.getElementById('code_project').style.display = "none"                                                               
                                                            }
                                                            });
                                                    </script>

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
                                            <th>Project</th>
                                            <th>Keterangan</th>
                                            <th>Remarks</th>                                                                                    
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trans as $item)                                     
                                        <tr align="center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->barang->namaBarang->nama }}</td>
                                            <td>{{ $item->barang->namaBarang->unit }}</td> 
                                            <td>{{ $item->masuk }}</td>
                                            <td>{{ $item->keluar }}</td>                                         
                                            <td>{{ $item->stock}}</td> 
                                            <td>{{ $item->project->nama}}</td>                                          
                                            <td>{{ $item->keterangan }}</td>
                                            <td>{{ $item->remark }}</td>
                                            <td>
                                                <!-- EDIT DATA -->
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
                                                <!-- END EDIT DATA --> 
                                                <!-- HAPUS DATA -->
                                                <form action="/transaksi/{{ $item->id }}" method="POST" class="d-inline">
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
                                        <!-- MODAL TAMBAH DATA -->
                                        <div class="modal fade" id="modalEditData{{ $item->id }}" tabindex="-1" aria-labelledby="modalEditData" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="title">Edit Transaksi</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="/transaksi/{{ $item->id }}" id="addTransaksi">
                                                                    @method('put')
                                                                    @csrf
                                                                    <div class="form-floating mb-3">
                                                                        <label for="floatingInput2">Tanggal</label>
                                                                        <input type="date" value="{{ old('tgl', $item->tgl) }}" name="tgl" id="tgl" required class="form-control">
                                                                        
                                                                    </div>
                                                                    <div class="form-floating mb-3">
                                                                        <label for="floatingInput6">Material Name</label>
                                                                        <select name="id_barang" id="id_barang" class="form-control">
                                                                        @foreach ($barngs as $bar)
                                                                            <option value="{{ $bar->id }}" {{ $bar->id == $item->id_barang ? "selected" : "" }}>{{ $bar->nama }}</option>
                                                                        @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-floating mb-3">
                                                                        <label for="floatingInput4">Stock In</label>
                                                                        <input value="{{ old('masuk', $item->masuk) }}" required name="masuk" type="number" required class="form-control" id="masuk">
                                                                    </div>
                                                                    <div class="form-floating mb-3">
                                                                        <label for="floatingInput5">Stock Out</label>
                                                                        <input value="{{ old('keluar', $item->keluar) }}" required name="keluar" type="number" required class="form-control" id="keluar">
                                                                    </div>
                                                                    <div class="form-floating mb-3">
                                                                        <label for="floatingInput5">Keterangan</label>
                                                                        <input value="{{ old('keterangan', $item->keterangan) }}" required name="keterangan" type="text" required class="form-control" id="keterangan">
                                                                    </div>
                                                                    <div class="form-floating mb-3">
                                                                        <label for="floatingInput5">Remarks</label>
                                                                        <input value="{{ old('remark', $item->remark) }}" required name="remark" type="text" required class="form-control" id="remark">
                                                                    </div>
                                                                    
                                                                    <div class="input-group">
                                                                        <button class="btn btn-primary" >Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END TAMBAH DATA -->
                                        @endforeach                                                                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
           
@endsection