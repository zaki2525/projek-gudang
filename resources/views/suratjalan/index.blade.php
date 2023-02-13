
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
                                    Tambah Surat
                                </button>
                                @foreach($kops as $kop)
                                <button type="button" class="btn btn-primary mb-1" data-toggle="modal"
                                    data-target="#modalTambahKop{{ $kop->id }}">
                                    <!-- <i class='bx bx-plus-medical'></i> -->
                                    Kop Surat
                                </button>
                                @endforeach
                            @endif

                            <a href="{{ route('suratjalan.history') }}">
                                <button type="button" class="btn btn-primary mb-1">
                                    <!-- <i class='bx bx-plus-medical'></i> -->
                                    Riwayat
                                </button>
                            </a>
                        @else
                            <a href="/suratjalan">
                                <button type="button" class="btn btn-primary mb-1">
                                    <!-- <i class='bx bx-plus-medical'></i> -->
                                    Kembali
                                </button>
                            </a>
                        @endif

                        @foreach($kops as $kop)
                        <!-- MODAL TAMBAH KOP -->
                        <div class="modal fade" id="modalTambahKop{{ $kop->id }}" tabindex="-1" aria-labelledby="modalTambahKop"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="title">Kop Surat</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/suratjalan/{{ $kop->id }}" method="post" enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            <div class="mb-3">
                                                <input type="hidden" name="id" id="id" value="{{$kop->id}}">
                                                <label for="image" class="form-label">Kop Surat saat ini</label>
                                                
                                                    <img src="{{ asset('storage/' . $kop->foto) }}" class="img-fluid mb-3 col-sm-5">
                                                
                                                <label for="image1" class="form-label">Preview Kop Surat</label>
                                                    <img class="img-preview img-fluid mb-3 col-sm-5">
                                                
                                                <input name="foto" class="form-control" value="{{ old('foto', $kop->foto) }}" type="file" id="image" onchange="previewImage()">      
                                            </div>
                                            <div class="input-group">
                                                <button class="btn btn-success rounded me-1" type="submit">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END TAMBAH KOP -->
                        @endforeach
                        <!-- MODAL TAMBAH DATA -->
                        <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="modalTambahBarang"
                            aria-hidden="true">
                            <div class="modal-dialog" style="width: 850px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="title">Create New Surat</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('suratjalan.store') }}" id="addTransaksi">
                                            @csrf
                                            <div class="form-floating mb-3">
                                                <label for="floatingInput4">Delivery To</label>
                                                <input value="{{ old('delivery') }}" required name="delivery" type="text"
                                                    required class="form-control" id="delivery">
                                            </div>

                                            <div class="form-floating mb-3">
                                                <label for="floatingInput4">To</label>
                                                <input value="{{ old('kepada') }}" required name="kepada" type="text"
                                                    required class="form-control" id="kepada">
                                            </div>

                                            <div class="form-floating mb-3">
                                                <label for="floatingInput6">Projek Name</label>
                                                <select name="id_project" id="id_project" class="form-control">
                                                    <option value="">Default</option>
                                                    @foreach ($projects as $project)
                                                        <option value="{{ $project->id }}">{{ $project->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-floating mb-3 barang-container">
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="floatingInput6">Barang</label>
                                                    </div>
                                                    <div class="col d-flex justify-content-end ">

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <select name="id_barang[]" class="form-control id_barang"
                                                            id="id_barang">
                                                            <option>
                                                                Select
                                                            </option>
                                                            @foreach ($barangs as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="number" name="keluar[]" class="form-control"
                                                            placeholder="Qty" value="1">
                                                    </div>
                                                    <div class="col input-group">
                                                        <input value="" name="remark[]" type="text"
                                                            class="form-control" id="remark" placeholder="remark">
                                                        <button type="" class="btn btn-primary btn-sm btn-add-barang"
                                                            style="border-top-left-radius:0;border-bottom-left-radius:0">Add
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                            {{-- <script>
                                                $(document).ready(function() {
                                                    $('#id_project').on('change', function() {
                                                        $("#id_barang").html('');
                                                        $.ajax({
                                                            url: "{{ url('suratjalan/fetch') }}",
                                                            type: "POST",
                                                            data: {
                                                                id_project: this.value,
                                                                _token: '{{ csrf_token() }}'
                                                            },
                                                            dataType: 'json',
                                                            success: function(result) {
                                                                $('.id_barang').html('<option value="" selected>Select</option>');
                                                                $.each(result.barang, function(key, value) {
                                                                    $(".id_barang").append(
                                                                        '<option name="id_barang" value="' + value
                                                                        .id_barang + '">' + value.barang.nama_barang.nama +
                                                                        '</option>');
                                                                });
                                                            }
                                                        });
                                                    });

                                                });
                                            </script> --}}

                                            <script>
                                                $('.btn-add-barang').click(function() {
                                                    // $("#id_barang").html('');
                                                    // $.ajax({
                                                    //     url: "{{ url('suratjalan/fetch') }}",
                                                    //     type: "POST",
                                                    //     data: {                                                          
                                                    //         _token: '{{ csrf_token() }}'
                                                    //     },
                                                    //     dataType: 'json',
                                                    //     success: function(result) {
                                                    //         $('.id_barang').html('<option value="" selected>Select</option>');
                                                    //         $.each(result.barang, function(key, value) {
                                                    //             $(".id_barang").append(
                                                    //                 '<option name="id_barang" value="' + value
                                                    //                 .id + '">' + value.nama_barang.nama +
                                                    //                 '</option>');
                                                    //         });
                                                    //     }
                                                    // });
                                                    $('.barang-container').append(barang())
                                                })

                                                $(document).on('click', '.btn-delete-barang', function() {
                                                    $(this).closest('.barang').remove()
                                                })

                                                function barang() {
                                                    return `<div class="row barang mt-2">
                                                        <div class="col">
                                                        <select name="id_barang[]" class="form-control id_barang"
                                                            id="id_barang">
                                                            <option>
                                                                Select
                                                            </option>  
                                                            @foreach ($barangs as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->nama }}</option>
                                                            @endforeach
                                                        
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="number" name="keluar[]" class="form-control"
                                                            placeholder="Qty" value="1">
                                                    </div>
                                                    <div class="col input-group">
                                                        <input value="" 
                                                            name="remark[]" type="text"
                                                            class="form-control" id="remark" placeholder="remark">
                                                            <button class="btn btn-sm btn-danger btn-delete-barang" style="border-top-left-radius:0;border-bottom-left-radius:0"                                                            >
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
                                                    </div>                                                    
                                                    </div>`
                                                }
                                            </script>

                                            <div class="form-floating mb-3">
                                                <label for="floatingInput4">No SJ</label>
                                                <input value="{{ old('no_sj') }}" required name="no_sj" type="text"
                                                    required class="form-control" id="no_sj">
                                            </div>

                                            <div class="form-floating mb-3">
                                                <label for="floatingInput4">No Mobil</label>
                                                <input value="{{ old('no_mobil') }}" required name="no_mobil"
                                                    type="text" required class="form-control" id="no_mobil">
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
                                    <th>Delivery To</th>
                                    <th>To</th>
                                    <th>Project</th>
                                    <th>No SJ</th>
                                    <th>Date</th>
                                    <th>No Mobil</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr align="center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->delivery }}</td>
                                        <td>{{ $item->kepada }}</td>
                                        <td>{{ $item->project->nama }}</td>
                                        <td>{{ $item->no_sj }}</td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td>{{ $item->no_mobil }}</td>
                                        <td>
                                            <a href="/suratjalan/{{ $item->id }}">
                                                <button type="button" class="btn btn-primary mb-1">
                                                    <!-- <i class='bx bx-plus-medical'></i> -->
                                                    Cetak
                                                </button>
                                            </a>
                                            <!-- EDIT DATA -->
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
                                            <!-- END EDIT DATA -->
                                            <!-- HAPUS DATA -->
                                            {{-- <form action="/suratjalan/{{ $item->id }}" method="POST" class="d-inline">
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
                                                </form> --}}
                                            <!-- END HAPUS DATA -->
                                        </td>
                                    </tr>
                                    {{-- <!-- MODAL EDIT DATA -->
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
                                                    <form method="POST" action="/suratjalan/{{ $item->id }}"
                                                        id="addTransaksi">
                                                        @method('put')
                                                        @csrf
                                                        <div class="form-floating mb-3">
                                                            <label for="floatingInput6">Material Name</label>
                                                            <select name="id_barang" id="id_barang" class="form-control">
                                                                @foreach ($barngs as $bar)
                                                                    <option value="{{ $bar->id }}"
                                                                        {{ $bar->id == $item->id_barang ? 'selected' : '' }}>
                                                                        {{ $bar->namaBarang->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-floating mb-3">
                                                            <label for="floatingInput6">Projek Name</label>
                                                            <select name="id_project" id="id_project"
                                                                class="form-control">
                                                                <option value="">Default</option>
                                                                @foreach ($pros as $bar)
                                                                    <option value="{{ $bar->id }}"
                                                                        {{ $bar->id == $item->id_project ? 'selected' : '' }}>
                                                                        {{ $bar->nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @if ($item->code_project == '')
                                                            <div class="form-floating mb-3 menu" id="code_project"
                                                                style='display:none'>
                                                                <label for="floatingInput5">Code Projek</label>
                                                                <input
                                                                    value="{{ old('code_project', $item->code_project) }}"
                                                                    name="code_project" type="text"
                                                                    class="form-control" id="code_project">
                                                            </div>
                                                        @else
                                                            <div class="form-floating mb-3 menu" id="code_project"
                                                                style='display'>
                                                                <label for="floatingInput5">Code Projek</label>
                                                                <input
                                                                    value="{{ old('code_project', $item->code_project) }}"
                                                                    name="code_project" type="text"
                                                                    class="form-control" id="code_project">
                                                            </div>
                                                        @endif

                                                        <div class="code-container">
                                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                                                                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
                                                            <script>
                                                                $('#id_project').on('change', function() {
                                                                    // const selected = $(this).find('option:selected');
                                                                    const selected = document.getElementById('id_project').value;
                                                                    if (selected != '') {
                                                                        document.getElementById('code_project').style.display = "block"
                                                                    } else {
                                                                        document.getElementById('code_project').style.display = "none"
                                                                    }
                                                                });
                                                            </script>
                                                            <div class="form-floating mb-3">
                                                                <label for="floatingInput4">Stock In</label>
                                                                <input value="{{ old('masuk', $item->masuk) }}" required
                                                                    name="masuk" type="number" required
                                                                    class="form-control" id="masuk">
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <label for="floatingInput5">Stock Out</label>
                                                                <input value="{{ old('keluar', $item->keluar) }}" required
                                                                    name="keluar" type="number" required
                                                                    class="form-control" id="keluar">
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <label for="floatingInput5">Keterangan</label>
                                                                <input value="{{ old('keterangan', $item->keterangan) }}"
                                                                    required name="keterangan" type="text" required
                                                                    class="form-control" id="keterangan">
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <label for="floatingInput5">Remarks</label>
                                                                <input value="{{ old('remark', $item->remark) }}" required
                                                                    name="remark" type="text" required
                                                                    class="form-control" id="remark">
                                                            </div>

                                                            <div class="input-group">
                                                                <button class="btn btn-primary">Update</button>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END TAMBAH DATA --> --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
