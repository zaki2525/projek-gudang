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
                                <button type="button" class="btn btn-primary mb-1" data-toggle="modal"
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
                                        <form method="POST" action="{{ route('transaksi.store') }}" id="addTransaksi">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput6">Tanggal</label>
                                                <input type="date" name="created_at" class="form-control"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput6">Material Name</label>
                                                <select name="id_barang" id="id_barang" class="form-control">
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
                                                        <input value="{{ old('masuk', 0) }}" name="masuk" type="number"
                                                            required class="form-control" id="masuk">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <label for="floatingInput5">Stock Out</label>
                                                        <input value="{{ old('keluar', 0) }}" name="keluar" type="number"
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

                                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#dari').on('change', function() {
                                                        // $("#dari").html('');
                                                        $.ajax({
                                                            url: "{{ url('transaksi/fetch') }}",
                                                            type: "POST",
                                                            data: {
                                                                id_project: this.value,
                                                                _token: '{{ csrf_token() }}'
                                                            },
                                                            dataType: 'json',
                                                            success: function(result) {
                                                                $('#id_barang').html('<option value="" selected>Select</option>');
                                                                const selected = document.getElementById('dari').value;
                                                                if (selected == '') {
                                                                    $.each(result.barang, function(key, value) {
                                                                        $("#id_barang").append(
                                                                            '<option name="id_barang" value="' + value
                                                                            .id + '">' + value.nama_barang
                                                                            .nama +
                                                                            '</option>');
                                                                    });
                                                                } else {
                                                                    $.each(result.barang, function(key, value) {
                                                                        $("#id_barang").append(
                                                                            '<option name="id_barang" value="' + value
                                                                            .id_barang + '">' + value.barang.nama_barang
                                                                            .nama +
                                                                            '</option>');
                                                                    });
                                                                }
                                                            }
                                                        });
                                                    });

                                                });
                                            </script>

                                            <div class="form-floating mb-3">
                                                <label for="floatingInput6">Ke</label>
                                                <select name="ke" id="ke" class="form-control project">
                                                    <option value="">None</option>
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
                                                <input value="{{ old('keterangan') }}" name="keterangan" type="text"
                                                    class="form-control" id="keterangan">
                                            </div>
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput5">Remarks</label>
                                                <input value="{{ old('remark') }}" name="remark" type="text"
                                                    class="form-control" id="remark">
                                            </div>

                                            <div class="input-group">
                                                <button class="btn btn-primary">Create</button>
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
                                    <th>Dari</th>
                                    <th>Ke</th>
                                    <th>Keterangan</th>
                                    <th>Remarks</th>
                                    @if (auth()->user()->role == 'admin')
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trans as $item)
                                    <tr align="center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td><a
                                                href="/barang/{{ $item->id_barang }}">{{ $item->barang->namaBarang->nama }}</a>
                                        </td>
                                        <td>{{ $item->barang->namaBarang->unit }}</td>
                                        <td>{{ $item->masuk }}</td>
                                        <td>{{ $item->keluar }}</td>
                                        <td>{{ $item->stock }}</td>
                                        <td><a href="/bproject/{{ $item->dari }}">{{ $item->dariproject->nama }}</a>
                                        </td>
                                        <td><a href="/bproject/{{ $item->ke }}">{{ $item->keproject->nama }}</a></td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->remark }}</td>
                                        @if (auth()->user()->role == 'admin')
                                            <td>
                                                <!-- EDIT DATA -->
                                                <button id="btn-edit" type="button" class="btn btn-dark btn-sm"
                                                    data-toggle="modal" data-target="#modalEditData{{ $item->id }}">
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
                                            </td>
                                        @endif
                                    </tr>
                                    <!-- MODAL EDIT DATA -->
                                    <div class="modal fade" id="modalEditData{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="modalEditData" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="title">Edit Transaksi</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="/transaksi/{{ $item->id }}"
                                                        id="addTransaksi">
                                                        @method('put')
                                                        @csrf
                                                        <div class="form-floating mb-3">
                                                            <label for="floatingInput6">Tanggal</label>
                                                            <input type="date" name="created_at" class="form-control"
                                                                value="{{ old('created_at', $item->created_at->format('Y-m-d')) }}">
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <label for="floatingInput6">Material Name</label>
                                                            <select name="id_barang" id="id_barang-edit"
                                                                class="form-control">
                                                                <option value="">Select</option>
                                                                {{-- @foreach ($barngs as $bar)
                                                                    <option value="{{ $bar->id }}" {{$item->id_barang == $bar->id ? "selected":""}} >{{ $bar->namaBarang->nama }}
                                                                    </option>
                                                                @endforeach --}}
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <label for="floatingInput4">Stock In</label>
                                                                    <input value="{{ old('masuk', $item->masuk) }}"
                                                                        name="masuk" type="number" required
                                                                        class="form-control" id="masuk">
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <label for="floatingInput5">Stock Out</label>
                                                                    <input value="{{ old('keluar', $item->keluar) }}"
                                                                        name="keluar" type="number" required
                                                                        class="form-control" id="keluar">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <label for="floatingInput6">Dari</label>
                                                            <select name="dari" id="dari-edit"
                                                                class="form-control project-edit">
                                                                <option value="">None</option>
                                                                @foreach ($pros as $bar)
                                                                    <option value="{{ $bar->id }}"
                                                                        {{ $item->dari == $bar->id ? 'selected' : '' }}>
                                                                        {{ $bar->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @if ($item->dari = null)
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $('#btn-edit').on('click', function() {
                                                                        $.ajax({
                                                                            url: "{{ url('transaksi/fetch') }}",
                                                                            type: "POST",
                                                                            data: {
                                                                                id_project: 0,
                                                                                _token: '{{ csrf_token() }}'
                                                                            },
                                                                            dataType: 'json',
                                                                            success: function(result) {
                                                                                $('#id_barang-edit').html('<option value="" selected>Select</option>');
                                                                                const selected = document.getElementById('dari-edit').value;
                                                                                if (selected == '') {
                                                                                    $.each(result.barang, function(key, value) {
                                                                                        if ({{ $item->id_barang }} == value.id) {
                                                                                            isselected = 'selected';
                                                                                        } else {
                                                                                            isselected = '';
                                                                                        }
                                                                                        $("#id_barang-edit").append(
                                                                                            '<option name="id_barang" value="' + value
                                                                                            .id + '">' + value.nama_barang
                                                                                            .nama +
                                                                                            '</option>');
                                                                                    });
                                                                                } else {
                                                                                    $.each(result.barang, function(key, value) {
                                                                                        if ({{ $item->id_barang }} == value.id_barang) {
                                                                                            isselected = 'selected';
                                                                                        } else {
                                                                                            isselected = '';
                                                                                        }
                                                                                        $("#id_barang-edit").append(
                                                                                            '<option name="id_barang" value="' + value
                                                                                            .id_barang + '">' + value.barang.nama_barang
                                                                                            .nama +
                                                                                            '</option>');
                                                                                    });
                                                                                }
                                                                            }
                                                                        });
                                                                    });
                                                                });
                                                            </script>
                                                        @else
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $('#btn-edit').on('click', function() {
                                                                        $.ajax({
                                                                            url: "{{ url('transaksi/fetch') }}",
                                                                            type: "POST",
                                                                            data: {
                                                                                id_project: 1,
                                                                                _token: '{{ csrf_token() }}'
                                                                            },
                                                                            dataType: 'json',
                                                                            success: function(result) {
                                                                                $('#id_barang-edit').html('<option value="" selected>Select</option>');
                                                                                const selected = document.getElementById('dari-edit').value;
                                                                                if (selected == '') {
                                                                                    $.each(result.barang, function(key, value) {
                                                                                        if ({{ $item->id_barang }} == value.id) {
                                                                                            isselected = 'selected';
                                                                                        } else {
                                                                                            isselected = '';
                                                                                        }
                                                                                        $("#id_barang-edit").append(
                                                                                            '<option name="id_barang" value="' + value
                                                                                            .id + '">' + value.nama_barang
                                                                                            .nama +
                                                                                            '</option>');
                                                                                    });
                                                                                } else {
                                                                                    $.each(result.barang, function(key, value) {
                                                                                        if ({{ $item->id_barang }} == value.id_barang) {
                                                                                            isselected = 'selected';
                                                                                        } else {
                                                                                            isselected = '';
                                                                                        }
                                                                                        $("#id_barang-edit").append(
                                                                                            '<option name="id_barang" value="' + value
                                                                                            .id_barang + '">' + value.barang.nama_barang
                                                                                            .nama +
                                                                                            '</option>');
                                                                                    });
                                                                                }
                                                                            }
                                                                        });
                                                                    });
                                                                });
                                                            </script>
                                                        @endif
                                                        <script>
                                                            $('#dari-edit').on('change', function() {
                                                            // $("#dari").html('');
                                                            $.ajax({
                                                                url: "{{ url('transaksi/fetch') }}",
                                                                type: "POST",
                                                                data: {
                                                                    id_project: this.value,
                                                                    _token: '{{ csrf_token() }}'
                                                                },
                                                                dataType: 'json',
                                                                success: function(result) {
                                                                    $('#id_barang-edit').html('<option value="" selected>Select</option>');
                                                                    const selected = document.getElementById('dari').value;
                                                                    if (selected == '') {
                                                                        $.each(result.barang, function(key, value) {
                                                                            $("#id_barang-edit").append(
                                                                                '<option name="id_barang" value="' + value
                                                                                .id + '"' +
                                                                                isselected +
                                                                                '>' + value.nama_barang
                                                                                .nama +
                                                                                '</option>');
                                                                        });
                                                                    } else {
                                                                        $.each(result.barang, function(key, value) {
                                                                            if ({{ $item->id_barang }} == value.id_barang) {
                                                                                isselected = 'selected';
                                                                            } else {
                                                                                isselected = '';
                                                                            }
                                                                            $("#id_barang-edit").append(
                                                                                '<option name="id_barang" value="' + value
                                                                                .id_barang + '"' +
                                                                                isselected +
                                                                                '>' + value.barang.nama_barang
                                                                                .nama +
                                                                                '</option>');
                                                                        });
                                                                    }
                                                                }
                                                            });
                                                            });

                                                            });
                                                        </script>

                                                        <div class="form-floating mb-3">
                                                            <label for="floatingInput6">Ke</label>
                                                            <select name="ke" id="ke-edit"
                                                                class="form-control project-edit">
                                                                <option value="">None</option>
                                                                @foreach ($pros as $bar)
                                                                    <option value="{{ $bar->id }}"
                                                                        {{ $item->ke == $bar->id ? 'selected' : '' }}>
                                                                        {{ $bar->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-floating mb-3 menu" id="code_project-edit"
                                                            style='display:none'>
                                                            <label for="floatingInput5">Code Projek</label>
                                                            <input value="{{ old('code_project', $item->code_project) }}"
                                                                name="code_project" type="text" class="form-control"
                                                                id="code_project_form-edit">
                                                        </div>

                                                        <div class="code-container">
                                                            <script>
                                                                $('.project-edit').on('change', function() {
                                                                    // const selected = $(this).find('option:selected');
                                                                    const selecteddari = document.getElementById('dari-edit').value;
                                                                    const selectedke = document.getElementById('ke-edit').value;
                                                                    if (selecteddari != '' || selectedke != '') {
                                                                        document.getElementById('code_project-edit').style.display = "block"
                                                                        // document.getElementById('ke').style.display = "block"
                                                                        // $('#code_project_form').val(''); 

                                                                    } else if (selecteddari == '' && selectedke == '') {
                                                                        document.getElementById('code_project-edit').style.display = "none"
                                                                        // document.getElementById('ke').style.display = "none"   
                                                                        $('#code_project_form-edit').val('');
                                                                    }
                                                                });
                                                            </script>

                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <label for="floatingInput5">Keterangan</label>
                                                            <input value="{{ old('keterangan', $item->keterangan) }}"
                                                                name="keterangan" type="text" class="form-control"
                                                                id="keterangan">
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <label for="floatingInput5">Remarks</label>
                                                            <input value="{{ old('remark', $item->remark) }}"
                                                                name="remark" type="text" class="form-control"
                                                                id="remark">
                                                        </div>

                                                        <div class="input-group">
                                                            <button class="btn btn-primary">Update</button>
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
