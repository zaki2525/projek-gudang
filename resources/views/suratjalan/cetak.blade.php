<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>DESAIN</title>
    <link rel="stylesheet" href="{{ asset('assets2/bootstrap/css/bootstrap.min.css') }}">
</head>

<body>
    @foreach($kops as $kop)
        @if(!$kop->foto)
        <img src="{{ asset('storage/kop/default.png') }}">
        @else
        <img src="{{ asset("storage/". $kop->foto) }}">
        @endif
    @endforeach
    <div class="row" style="width: 913px;">
        <div class="col">
            <div class="table-responsive" style="border-style: solid;height: 185.8px;width: 400px;border-radius: 35px;margin: 30px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="border-style: none;">Delivery To :</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-style: none;">{{$surat_jalan->delivery}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;border-style: none;">To&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : {{ $surat_jalan->kepada }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;border-style: none;">Project&nbsp; &nbsp; &nbsp; &nbsp; : {{ $surat_jalan->project->nama}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col" style="height: 235.8px;width: 382.6px;margin: 0px;padding: 0px;margin-right: px;">
            <div class="table-responsive" style="border-style: solid;height: 185.8px;width: 400px;border-radius: 35px;margin: 0px;padding: 0px;margin-bottom: 0px;margin-top: 30px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="border-style: none;">No SJ&nbsp; &nbsp; &nbsp; &nbsp; : {{ $surat_jalan->no_sj }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-style: none;font-weight: bold;">Date&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : {{ $surat_jalan->created_at }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;border-style: none;">No Mobil&nbsp; : {{ $surat_jalan->no_mobil }}</td>
                        </tr>
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="table-responsive" style="margin: 30px;width: 855px;text-align: center;border-style: solid;height: 700px;font-size: 18px;">
        <table class="table">
            <thead style="border-style: solid;">
                <tr style="border-style: solid;color: var(--bs-black);">
                    <th style="border-color: var(--bs-black);border-right-color: var(--bs-table-color);">No</th>
                    <th style="color: var(--bs-black);border-color: var(--bs-black);">Qty</th>
                    <th style="border-color: var(--bs-black);">Unit</th>
                    <th style="border-color: var(--bs-black);">Description</th>
                    <th style="border-color: var(--bs-black);">Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($surat_jalan_items as $item)
                <tr>
                <td>{{ $loop->iteration }}</td> 
                <td>{{ $item->keluar }}</td> 
                <td>{{ $item->barang->unit }}</td>
                <td>{{ $item->barang->nama }} </td>
                <td>{{ $item->remark }}</td>
                </tr>                   
                @endforeach     
                </tr>
            </tbody>
        </table>
    </div><input class="form-control-plaintext" type="text" readonly="" style="width: 900px;font-style: italic;margin-left: 71px;margin-top: -29px;" value="*Received in Good Condition">
    <div class="row" style="width: 855px;margin-left: 29px;">
        <div class="col" style="width: 213.8px;height: 158.8px;">
            <div class="table-responsive" style="border-style: solid;height: 115.8px;width: 160px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="border-style: solid;border-color: var(--bs-table-striped-color);text-align: center;">Issued by</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive" style="margin-left: -8px;">
                <table class="table">
                    <thead>
                        <tr style="margin-left: 0px;margin-right: 0px;">
                            <th style="border-style: none;font-size: 14px;margin: 0px;margin-left: 0px;margin-right: 0px;">Name :</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr></tr>
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col" style="margin-right: 0px;margin-left: -18px;">
            <div class="table-responsive" style="border-style: solid;height: 115.8px;width: 160px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="border-style: solid;border-color: var(--bs-table-striped-color);text-align: center;">Approved by</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive" style="margin-left: -8px;">
                <table class="table">
                    <thead>
                        <tr style="margin-left: 0px;margin-right: 0px;">
                            <th style="border-style: none;font-size: 14px;margin: 0px;margin-left: 0px;margin-right: 0px;">Name :</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr></tr>
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col" style="margin-left: -17px;">
            <div class="table-responsive" style="border-style: solid;height: 115.8px;width: 160px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="border-style: solid;border-color: var(--bs-table-striped-color);text-align: center;">Delivered by<br></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive" style="margin-left: -8px;">
                <table class="table">
                    <thead>
                        <tr style="margin-left: 0px;margin-right: 0px;">
                            <th style="border-style: none;font-size: 14px;margin: 0px;margin-left: 0px;margin-right: 0px;">Name :</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr></tr>
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col" style="margin-left: -15px;">
            <div class="table-responsive" style="border-style: solid;height: 115.8px;width: 160px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="border-style: solid;border-color: var(--bs-table-striped-color);text-align: center;">Security<br></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive" style="margin-left: -8px;">
                <table class="table">
                    <thead>
                        <tr style="margin-left: 0px;margin-right: 0px;">
                            <th style="border-style: none;font-size: 14px;margin: 0px;margin-left: 0px;margin-right: 0px;">Name :</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr></tr>
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col" style="margin-left: -15px;">
            <div class="table-responsive" style="height: 115.8px;width: 160px;border-style: none;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="text-align: center;border-style: none;border-color: var(--bs-table-striped-color);">Recived by<br></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                        <tr>
                            <td style="border-style: none;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive" style="margin-left: -6px;">
                <table class="table">
                    <thead>
                        <tr style="margin-left: 0px;margin-right: 0px;width: 168px;">
                            <th style="border-style: none;font-size: 14px;margin: 0px;margin-left: 0px;margin-right: 0px;">&nbsp;(&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr></tr>
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets2/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>