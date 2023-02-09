@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <h1>Last Update Transaction</h1>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trans as $item)
                                    <tr align="center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td><a
                                                href="/barang/{{ $item->id_barang }}">{{ $item->barang->nama }}</a>
                                        </td>
                                        <td>{{ $item->barang->unit }}</td>
                                        <td>{{ $item->masuk }}</td>
                                        <td>{{ $item->keluar }}</td>
                                        <td>{{ $item->stock }}</td>
                                        <td><a href="/bproject/{{ $item->dari }}">{{ $item->dariproject->nama }}</a></td>
                                        <td><a href="/bproject/{{ $item->ke }}">{{ $item->keproject->nama }}</a></td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->remark }}</td>
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
