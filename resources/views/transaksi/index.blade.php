@extends('layouts.app')

@section('content')

    @include('sweetalert::alert')

    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div>

                        @if ($history == false)
                            @if (auth()->user()->role == 'admin')
                                <!-- Tambah Data -->
                                <button id="btnShowFormMaster" type="button" class="btn btn-primary mb-1" data-toggle="modal"
                                    data-target="#modalTambahData">
                                    <!-- <i class='bx bx-plus-medical'></i> -->
                                    Transaksi Barang
                                </button>
                            @endif

                            <a href="{{ route('transaksi.history') }}">
                                <button type="button" class="btn btn-primary mb-1">
                                    <!-- <i class='bx bx-plus-medical'></i> -->
                                    Riwayat
                                </button>
                            </a>
                        @else
                            <a href="/transaksi">
                                <button type="button" class="btn btn-primary mb-1">
                                    <!-- <i class='bx bx-plus-medical'></i> -->
                                    Kembali
                                </button>
                            </a>
                        @endif

                        <!-- MODAL TAMBAH DATA -->
                        <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahBarang"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="title">Create New Transaksi</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addTransaksi">
                                            {{-- @csrf --}}
                                            <div class="form-floating mb-3">
                                                <input type="hidden" name="id" id="id">
                                                <label for="floatingInput6">Tanggal</label>
                                                <input id="tanggal" type="date" name="created_at" class="form-control"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput6">Material Name</label>
                                                <select name="id_barang" id="id_barang" class="form-control ">
                                                    <option value="">Select</option>
                                                    @foreach ($barngs as $bar)
                                                        <option value="{{ $bar->id }}">{{ $bar->namaBarang->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput4">Stock In</label>
                                                        <input id="masuk" value="{{ old('masuk', 0) }}" name="masuk" type="number"
                                                            required class="form-control" id="masuk">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput5">Stock Out</label>
                                                        <input id="keluar" value="{{ old('keluar', 0) }}" name="keluar" type="number"
                                                            required class="form-control" id="keluar">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <label for="floatingInput6">Dari</label>
                                                <select name="dari" id="dari" class="form-control project">
                                                    <option value="">None</option>
                                                    @foreach ($pros as $bar)
                                                        <option value="{{ $bar->id }}">{{ $bar->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>                                     

                                            <div class="form-floating mb-3">
                                                <label for="floatingInput6">Ke</label>
                                                <select name="ke" id="ke" class="form-control project">
                                                    <option value="">Keluar Gudang</option>
                                                    @foreach ($pros as $bar)
                                                        <option value="{{ $bar->id }}">{{ $bar->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-floating mb-3 menu" id="code_project" style='display:none'>
                                                <label for="floatingInput5">Code Projek</label>
                                                <input value="{{ old('code_project') }}" name="code_project" type="text"
                                                    class="form-control" id="code_project_form">
                                            </div>

                                            <div class="code-container">
                                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                                                    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
                                                <script>
                                                    $('.project').on('change', function() {
                                                        // const selected = $(this).find('option:selected');
                                                        const selecteddari = document.getElementById('dari').value;
                                                        const selectedke = document.getElementById('ke').value;
                                                        if (selecteddari != '' || selectedke != '') {
                                                            document.getElementById('code_project').style.display = "block"
                                                            // document.getElementById('ke').style.display = "block"
                                                            // $('#code_project_form').val(''); 

                                                        } else if (selecteddari == '' && selectedke == '') {
                                                            document.getElementById('code_project').style.display = "none"
                                                            // document.getElementById('ke').style.display = "none"   
                                                            $('#code_project_form').val('');
                                                        }
                                                    });
                                                </script>

                                            </div>
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput5">Keterangan</label>
                                                <input id="keterangan" value="{{ old('keterangan') }}" name="keterangan" type="text"
                                                    class="form-control" id="keterangan">
                                            </div>
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput5">Remarks</label>
                                                <input id="remark" value="{{ old('remark') }}" name="remark" type="text"
                                                    class="form-control" id="remark">
                                            </div>

                                            <div class="input-group">                                            
                                                <input type="button" class="btn btn-primary" id="btnCreate" value="Create">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END TAMBAH DATA -->
                    </div>

                    <div class="table-responsive mb-4 mt-4">
                        <table class="table table-hover non-hover data-table" style="width:100%">
                            <thead>
                                <tr align="center">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Material Name</th>
                                    <th>Unit</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>Stock</th>
                                    <th>Dari</th>
                                    <th>Ke</th>
                                    <th>Keterangan</th>
                                    <th>Remarks</th>
                                    @if (auth()->user()->role == 'admin')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection