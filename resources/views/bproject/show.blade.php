@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">                                                      
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">  
                    <div>                
                        <a href="/bproject"><button type="button" class="btn btn-primary mb-1">                        
                                Kembali
                            </button>
                        </a>
                    </div>
                    <h3 class="text-center">{{$bproject->nama}}</h3>   
                    <div class="table-responsive mb-4 mt-4">
                        <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                            <thead>
                                <tr align="center">
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Stock</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>                            
                            <tbody>
                               @foreach($items as $item)
                               <tr align="center">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->barang->namabarang->nama}}</td>
                                <td>{{$item->stock}}</td>
                                <td>{{$item->barang->namabarang->unit}}</td>
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
