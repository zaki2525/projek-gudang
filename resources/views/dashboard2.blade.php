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
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->barang->namaBarang->nama }}</td>
                                            <td>{{ $item->barang->namaBarang->unit }}</td> 
                                            <td>{{ $item->masuk }}</td>
                                            <td>{{ $item->keluar }}</td>                                         
                                            <td>{{ $item->stock}}</td> 
                                            <td>{{ $item->dariproject->nama}}</td> 
                                            <td>{{ $item->keproject->nama}}</td>                                          
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