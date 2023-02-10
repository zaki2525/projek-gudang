@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div>
                        <a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary mb-1">
                                Kembali
                            </button>
                        </a>
                    </div>
                    <h3 class="text-center">{{ $barang->nama }}</h3>
                    <input type="number" value="{{$barang->id}}" hidden id="id_barang" name="id_barang">
                    <div class="table-responsive mb-4 mt-4">
                        <table class="table table-hover non-hover data-table1" style="width:100%">
                            <thead>
                                <tr align="center">
                                    <th>No</th>
                                    <th>Nama Project</th>
                                    <th>Stock</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody align="center">                                
                                {{-- @foreach ($datas as $item)
                                    <tr align="center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->project->nama }}</td>
                                        <td>{{ $item->stock }}</td>
                                        <td>{{ $item->barang->unit }}</td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
