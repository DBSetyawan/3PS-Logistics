<!doctype html>
<html lang="en">
<title>File jobs #{{$job_no}}</title>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="icon" href="{{ asset('img/logo.ico') }}" />
{{-- <link rel="shortcut icon" href="../img/logo.ico" /> --}}

<style type="text/css">
    .gray {
        background-color: lightslategray
    }
    table, th, td {
        padding: 1px;
        /* text-align: left; */
        font-size:11px;
        font-family: Fira Code;
        border: 1px solid black;
                border-collapse: collapse;
                width: 100%;
                height: 1%;
                /* font-size: x-small; */
    }

    .page-break {
        page-break-after: always;
        /* overflow: visible !important; */
    }
    .page-inside {
    page-break-inside: avoid;
    }
    .container{
  width: 25%;
  height: 50px;
  overflow: hidden;
  position: relative;
}
    body {
        top: -67px; left: 0px; right: 0px; height: 60px;
        /* margin-top: 1%; */
        font-size: 10px;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
</head>
<body>
    {{-- List indexing const data = value_akhir; (list data terakhir), tambahkan data terakhir paging = ( 25 + 6 )+1 ? index++ : ${data}, by default dalam 1 page adalah 6  --}}
    <div style="margin-right:3%;font-size:19px;text-align:right;position:inherit">JOB LIST</div>
    <table>
        @php $check=0 @endphp
        @foreach($shipments_common as $indexKey => $list)
        @php $check++ @endphp
        @if( $check % $list->count() == 1)
            <tr>
                <th colspan="2">
                    @if($data_company_id == "2")
                    <img style="
                    overflow: auto;
                    margin-left:2px;
                    margin-right: 2px;" height="38" width="74" HSPACE="10" VSPACE="9" align="left" src="{{asset('./img/3PE.png')}}" />
                     <font style="font-family: Arial;position:absolute;">
                            Represented By
                                <br/>
                                <font style="font-size: 13px;">
                                        {{ $nama_perusahaan }}
                                </font>
                                    <br/>
                                <font style="font-size: 9px;">
                                    {{ $alamat }}
                                </font>
                                <br/>
                                <br/>
                                    Email: info@3permata.co.id
                            </font>
                        @else
                            <img style="
                            overflow: auto;
                            margin-left:2px;
                            margin-right: 2px;" HSPACE="10" VSPACE="9" align="left" src="{{asset('./img/tiga-permata-logistik-surabaya-logo.png')}}" />
                             <font style="font-family: Arial;position:absolute;">
                                Represented By
                                <br/>
                                <font style="font-size: 13px;">
                                    {{ $nama_perusahaan }}
                                </font>
                                <br/>
                                <font style="font-size: 9px;">
                                    {{ $alamat }}
                                </font>
                                <br/>
                                <br/>
                                Email: info@3permata.co.id
                            </font>
                         @endif
                   </th>
                    <th colspan="6">
                        <img style="
                        overflow: auto;
                        margin-left:2px;
                        margin-top:-2px;
                        margin-right: 2px;" height="80" width="74" HSPACE="10" VSPACE="2" align="right" src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" />
                        <p style="transform: translate(-23%, -30%);">
                            Jobs Code: <br/>
                            <font style="font-family: Fira Code;font-size: 14px"> {{ $job_no}} </font>
                            <div style="left:2px;transform: translate(1%, 2%);"><br CLEAR="top"/>Created At
                            {{ $tgl_buat }}</div>
                        </p>
                    </th>
                </tr>
                    <tr>
                        @php $total=0 @endphp
                        @php $total=0 @endphp
                        @php $volume=0 @endphp
                        @php $total_weight=0 @endphp
                        @foreach($shipments_common as $indexKey => $listx)
                        {{ $total += $listx->transports->collie}}
                        {{ $volume += $listx->transports->chargeable_weight}}
                        {{ $total_weight += $listx->transports->actual_weight}}
                        @endforeach
                        @php $total @endphp
                        @php $volume @endphp
                        @php $total_weight @endphp
                        @php $shipment @endphp
                        <td ><font style="font-size: 12px;font-family:Arial">Total Shipment : {{ $shipments_common->count() }}</font></td>
                        <td style="height:30px" ><font style="font-size: 12px;font-family:Arial">Total Coli : {{ $total }}</font></td>
                        <td ><font style="font-size: 12px;font-family:Arial">Total Weight : {{ $total_weight }}</font></td>
                        <td colspan="5"><font style="font-size: 12px;font-family:Arial">Total Volume : {{ $volume }}</font></td>
                    </tr>
                 <tr><td style="height:1px" colspan="8"><div class="page-break"></div></td></tr>
            @endif
            @if( $check % $list->count() == 6)
            <tr><td colspan="8"><div class="page-inside"></div></td>
                <tr style="background-color: #b0b1b2;">
                    <td hei colspan="8" style="height:2px;text-align: left; font-weight: bold;"><font style="font-size:11px">I/We hereby acknowledge all the terms & condition stated on the reverse side as the terms & conditon of this contract and agree to be bound by</font></td>
                </tr>
            <tr>
                <th colspan="2">
                    @if($data_company_id == "2")
                    <img style="
                    overflow: auto;
                    margin-left:2px;
                    margin-right: 2px;" height="38" width="74" HSPACE="10" VSPACE="9" align="left" src="{{asset('./img/3PE.png')}}" />
                         <font style="font-family: Arial;position:absolute;">
                                Represented By
                                    <br/>
                                    <font style="font-size: 13px;">
                                            {{ $nama_perusahaan }}
                                    </font>
                                        <br/>
                                    <font style="font-size: 9px;">
                                        {{ $alamat }}
                                    </font>
                                    <br/>
                                    <br/>
                                        Email: info@3permata.co.id
                                </font>
                            @else
                                <img style="
                                overflow: auto;
                                margin-left:2px;
                                margin-right: 2px;" height="80" width="74" HSPACE="10" VSPACE="9" align="left" src="{{asset('./img/tiga-permata-logistik-surabaya-logo.png')}}" />
                                 <font style="font-family: Arial;position:absolute;">
                                    Represented By
                                    <br/>
                                    <font style="font-size: 13px;">
                                        {{ $nama_perusahaan }}
                                    </font>
                                    <br/>
                                    <font style="font-size: 9px;">
                                        {{ $alamat }}
                                    </font>
                                    <br/>
                                    <br/>
                                    Email: info@3permata.co.id
                                </font>
                             @endif
                       </th>
                        <th colspan="6">
                            <img style="
                            overflow: auto;
                            margin-left:2px;
                            margin-top:-2px;
                            margin-right: 2px;" height="80" width="74" HSPACE="10" VSPACE="2" align="right" src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" />
                            <p style="transform: translate(-23%, -30%);">
                                Jobs Code: <br/>
                                <font style="font-family: Fira Code;font-size: 14px"> {{ $job_no}} </font>
                                <div style="left:2px;transform: translate(1%, 2%);"><br CLEAR="top"/>Created At
                                {{ $tgl_buat }}</div>
                            </p>
                        </th>
                    </tr>
                        <tr>
                            @php $total=0 @endphp
                            @php $total=0 @endphp
                            @php $volume=0 @endphp
                            @php $total_weight=0 @endphp
                            @foreach($shipments_common as $indexKey => $listx)
                            {{ $total += $listx->transports->collie}}
                            {{ $volume += $listx->transports->chargeable_weight}}
                            {{ $total_weight += $listx->transports->actual_weight}}
                            @endforeach
                            @php $total @endphp
                            @php $volume @endphp
                            @php $total_weight @endphp
                            @php $shipment @endphp
                            <td ><font style="font-size: 12px;font-family:Arial">Total Shipment : {{ $shipments_common->count() }}</font></td>
                            <td style="height:30px" ><font style="font-size: 12px;font-family:Arial">Total Coli : {{ $total }}</font></td>
                            <td ><font style="font-size: 12px;font-family:Arial">Total Weight : {{ $total_weight }}</font></td>
                            <td colspan="5"><font style="font-size: 12px;font-family:Arial">Total Volume : {{ $volume }}</font></td>
                        </tr>
                    <tr><td style="height:1px" colspan="8"><div class="page-break"></div></td></tr>
                @endif
                @if( $check % $list->count() == 11)
                <tr><td colspan="8"><div class="page-inside"></div></td>
                    <tr style="background-color: #b0b1b2;">
                        <td colspan="8" style="text-align: left; font-weight: bold;"><font style="font-size:11px">I/We hereby acknowledge all the terms & condition stated on the reverse side as the terms & conditon of this contract and agree to be bound by</font></td>
                    </tr>
                    <tr>
                        <th colspan="2">
                            @if($data_company_id == "2")
                            <img style="
                            overflow: auto;
                            margin-left:2px;
                            margin-right: 2px;" height="38" width="74" HSPACE="10" VSPACE="9" align="left" src="{{asset('./img/3PE.png')}}" />
                             <font style="font-family: Arial;position:absolute;">
                                    Represented By
                                        <br/>
                                        <font style="font-size: 13px;">
                                                {{ $nama_perusahaan }}
                                        </font>
                                            <br/>
                                        <font style="font-size: 9px;">
                                            {{ $alamat }}
                                        </font>
                                        <br/>
                                        <br/>
                                            Email: info@3permata.co.id
                                    </font>
                                @else
                                    <img style="
                                    overflow: auto;
                                    margin-left:2px;
                                    margin-right: 2px;" height="80" width="74" HSPACE="10" VSPACE="9" align="left" src="{{asset('./img/tiga-permata-logistik-surabaya-logo.png')}}" />
                                     <font style="font-family: Arial;position:absolute;">
                                        Represented By
                                        <br/>
                                        <font style="font-size: 13px;">
                                            {{ $nama_perusahaan }}
                                        </font>
                                        <br/>
                                        <font style="font-size: 9px;">
                                            {{ $alamat }}
                                        </font>
                                        <br/>
                                        <br/>
                                        Email: info@3permata.co.id
                                    </font>
                                 @endif
                           </th>
                            <th colspan="6">
                                <img style="
                                overflow: auto;
                                margin-left:2px;
                                margin-top:-2px;
                                margin-right: 2px;" height="80" width="74" HSPACE="10" VSPACE="2" align="right" src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" />
                                <p style="transform: translate(-23%, -30%);">
                                    Jobs Code: <br/>
                                    <font style="font-family: Fira Code;font-size: 14px"> {{ $job_no}} </font>
                                    <div style="left:2px;transform: translate(1%, 2%);"><br CLEAR="top"/>Created At
                                    {{ $tgl_buat }}</div>
                                </p>
                            </th>
                        </tr>
                            <tr>
                                @php $total=0 @endphp
                                @php $total=0 @endphp
                                @php $volume=0 @endphp
                                @php $total_weight=0 @endphp
                                @foreach($shipments_common as $indexKey => $listx)
                                {{ $total += $listx->transports->collie}}
                                {{ $volume += $listx->transports->chargeable_weight}}
                                {{ $total_weight += $listx->transports->actual_weight}}
                                @endforeach
                                @php $total @endphp
                                @php $volume @endphp
                                @php $total_weight @endphp
                                @php $shipment @endphp
                                <td ><font style="font-size: 12px;font-family:Arial">Total Shipment : {{ $shipments_common->count() }}</font></td>
                                <td style="height:30px" ><font style="font-size: 12px;font-family:Arial">Total Coli : {{ $total }}</font></td>
                                <td ><font style="font-size: 12px;font-family:Arial">Total Weight : {{ $total_weight }}</font></td>
                                <td colspan="5"><font style="font-size: 12px;font-family:Arial">Total Volume : {{ $volume }}</font></td>
                            </tr>
                         <tr><td style="height:1px" colspan="8"><div class="page-break"></div></td></tr>
                    @endif
                    @if( $check % $list->count() == 16)
                    <tr><td colspan="8"><div class="page-inside"></div></td>
                        <tr style="background-color: #b0b1b2;">
                            <td colspan="8" style="text-align: left; font-weight: bold;"><font style="font-size:11px">I/We hereby acknowledge all the terms & condition stated on the reverse side as the terms & conditon of this contract and agree to be bound by</font></td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                @if($data_company_id == "2")
                                <img style="
                                overflow: auto;
                                margin-left:2px;
                                margin-right: 2px;" height="38" width="74" HSPACE="10" VSPACE="9" align="left" src="{{asset('./img/3PE.png')}}" />
                                 <font style="font-family: Arial;position:absolute;">
                                        Represented By
                                            <br/>
                                            <font style="font-size: 13px;">
                                                    {{ $nama_perusahaan }}
                                            </font>
                                                <br/>
                                            <font style="font-size: 9px;">
                                                {{ $alamat }}
                                            </font>
                                            <br/>
                                            <br/>
                                                Email: info@3permata.co.id
                                        </font>
                                    @else
                                        <img style="
                                        overflow: auto;
                                        margin-left:2px;
                                        margin-right: 2px;" HSPACE="10" VSPACE="9" align="left" src="{{asset('./img/tiga-permata-logistik-surabaya-logo.png')}}" />
                                         <font style="font-family: Arial;position:absolute;">
                                            Represented By
                                            <br/>
                                            <font style="font-size: 13px;">
                                                {{ $nama_perusahaan }}
                                            </font>
                                            <br/>
                                            <font style="font-size: 9px;">
                                                {{ $alamat }}
                                            </font>
                                            <br/>
                                            <br/>
                                            Email: info@3permata.co.id
                                        </font>
                                     @endif
                               </th>
                                <th colspan="6">
                                    <img style="
                                    overflow: auto;
                                    margin-left:2px;
                                    margin-top:-2px;
                                    margin-right: 2px;" height="80" width="74" HSPACE="10" VSPACE="2" align="right" src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" />
                                    <p style="transform: translate(-23%, -30%);">
                                        Jobs Code: <br/>
                                        <font style="font-family: Fira Code;font-size: 14px"> {{ $job_no}} </font>
                                        <div style="left:2px;transform: translate(1%, 2%);"><br CLEAR="top"/>Created At
                                        {{ $tgl_buat }}</div>
                                    </p>
                                </th>
                            </tr>
                                <tr>
                                    @php $total=0 @endphp
                                    @php $total=0 @endphp
                                    @php $volume=0 @endphp
                                    @php $total_weight=0 @endphp
                                    @foreach($shipments_common as $indexKey => $listx)
                                    {{ $total += $listx->transports->collie}}
                                    {{ $volume += $listx->transports->chargeable_weight}}
                                    {{ $total_weight += $listx->transports->actual_weight}}
                                    @endforeach
                                    @php $total @endphp
                                    @php $volume @endphp
                                    @php $total_weight @endphp
                                    @php $shipment @endphp
                                    <td ><font style="font-size: 12px;font-family:Arial">Total Shipment : {{ $shipments_common->count() }}</font></td>
                                    <td style="height:30px" ><font style="font-size: 12px;font-family:Arial">Total Coli : {{ $total }}</font></td>
                                    <td ><font style="font-size: 12px;font-family:Arial">Total Weight : {{ $total_weight }}</font></td>
                                    <td colspan="5"><font style="font-size: 12px;font-family:Arial">Total Volume : {{ $volume }}</font></td>
                                </tr>
                            <tr><td style="height:1px" colspan="8"><div class="page-break"></div></td></tr>
                        @endif
                        @if( $check % $list->count() == 25)
                        <tr><td colspan="8"><div class="page-inside"></div></td>
                            <tr style="background-color: #b0b1b2;">
                                <td colspan="8" style="text-align: left; font-weight: bold;"><font style="font-size:11px">I/We hereby acknowledge all the terms & condition stated on the reverse side as the terms & conditon of this contract and agree to be bound by</font></td>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    @if($data_company_id == "2")
                                    <img style="
                                    overflow: auto;
                                    margin-left:2px;
                                    margin-right: 2px;" height="38" width="74" HSPACE="10" VSPACE="9" align="left" src="{{asset('./img/3PE.png')}}" />
                                     <font style="font-family: Arial;position:absolute;">
                                            Represented By
                                                <br/>
                                                <font style="font-size: 13px;">
                                                        {{ $nama_perusahaan }}
                                                </font>
                                                    <br/>
                                                <font style="font-size: 9px;">
                                                    {{ $alamat }}
                                                </font>
                                                <br/>
                                                <br/>
                                                    Email: info@3permata.co.id
                                            </font>
                                        @else
                                            <img style="
                                            overflow: auto;
                                            margin-left:2px;
                                            margin-right: 2px;" HSPACE="10" VSPACE="9" align="left" src="{{asset('./img/tiga-permata-logistik-surabaya-logo.png')}}" />
                                             <font style="font-family: Arial;position:absolute;">
                                                Represented By
                                                <br/>
                                                <font style="font-size: 13px;">
                                                    {{ $nama_perusahaan }}
                                                </font>
                                                <br/>
                                                <font style="font-size: 9px;">
                                                    {{ $alamat }}
                                                </font>
                                                <br/>
                                                <br/>
                                                Email: info@3permata.co.id
                                            </font>
                                         @endif
                                   </th>
                                    <th colspan="6">
                                        <img style="
                                        overflow: auto;
                                        margin-left:2px;
                                        margin-top:-2px;
                                        margin-right: 2px;" height="80" width="74" HSPACE="10" VSPACE="2" align="right" src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" />
                                        <p style="transform: translate(-23%, -30%);">
                                            Jobs Code: <br/>
                                            <font style="font-family: Fira Code;font-size: 14px"> {{ $job_no}} </font>
                                            <div style="left:2px;transform: translate(1%, 2%);"><br CLEAR="top"/>Created At
                                            {{ $tgl_buat }}</div>
                                        </p>
                                    </th>
                                </tr>
                                    <tr>
                                        @php $total=0 @endphp
                                        @php $total=0 @endphp
                                        @php $volume=0 @endphp
                                        @php $total_weight=0 @endphp
                                        @foreach($shipments_common as $indexKey => $listx)
                                        {{ $total += $listx->transports->collie}}
                                        {{ $volume += $listx->transports->chargeable_weight}}
                                        {{ $total_weight += $listx->transports->actual_weight}}
                                        @endforeach
                                        @php $total @endphp
                                        @php $volume @endphp
                                        @php $total_weight @endphp
                                        @php $shipment @endphp
                                        <td ><font style="font-size: 12px;font-family:Arial">Total Shipment : {{ $shipments_common->count() }}</font></td>
                                        <td style="height:30px" ><font style="font-size: 12px;font-family:Arial">Total Coli : {{ $total }}</font></td>
                                        <td ><font style="font-size: 12px;font-family:Arial">Total Weight : {{ $total_weight }}</font></td>
                                        <td colspan="5"><font style="font-size: 12px;font-family:Arial">Total Volume : {{ $volume }}</font></td>
                                    </tr>
                        <tr><td style="height:1px" colspan="8"><div class="page-break"></div></td></tr>
                    @endif
                <tr>
                    <td colspan="7"> <p align="top">
                        <p style="
                        position: relative;
                        transform: translate(1%, 12%);">
                            <font style="font-size: 19px;">#{{$check}}</font>
                            {{-- <span style=" transform: translate(21%, 12%);display:inline-block;width:110px;"><font style="font-size: 12px;font-family:Arial"> Total Shipment : {{ $list->shipment_id }}</font></span> --}}
                            <span style=" transform: translate(18%, 19%);display:inline-block;width:87px;"><font style="font-size: 12px;font-family:Arial"> Shipment </span><font style="font-size: 12px;font-family:Arial">: {{ $list->shipment_id }} </font>
                            <span style=" transform: translate(30%, 13%);display:inline-block;width:97px;"><font style="font-size: 12px;font-family:Arial">  Total Volume : {{ $list->transports->chargeable_weight }}</font></span>
                            <span style=" transform: translate(30%, 14%);display:inline-block;width:97px;"><font style="font-size: 12px;font-family:Arial">  Total Weight : {{ $list->transports->actual_weight }}</font></span>
                            <span style=" transform: translate(30%, 14%);display:inline-block;width:97px;"><font style="font-size: 12px;font-family:Arial">  Total Weight : {{ $list->transports->actual_weight }}</font></span>
                        </p>
                            <p style="font-size:12px;
                                position: relative;
                                transform: translate(3%, 3%);">
                                <span style=" transform: translate(-9%, 10%);display:inline-block;width:97px;"><font style="font-size:14px;font-family:Fira Code "><b>Shipper detail:</b></font></span>
                            </p>
                            <p style="font-size:12px;
                                position: relative;
                                transform: translate(3%, 9%);">
                                {{-- <span style=" transform: translate(2%, 30%);display:inline-block;width:97px;"> Origin</span>:  --}}
                                <span style=" transform: translate(2%, 25%);display:inline-block;width:70px;"> Origin</span><span style=" transform: translate(-20%, 20%);display:inline-block;width:170px;">: {{ $list->transports->origin}}</span>
                                <span style=" transform: translate(33%, 23%);display:inline-block;width:70px;"> Destination</span><span style=" transform: translate(6%, 20%);display:inline-block;width:200px;">: {{ $list->transports->destination}}</span>
                                {{-- <span style=" transform: translate(25%, 30%);display:inline-block;width:200px;"> Destination</span>: {{ $list->transports->destination}} --}}
                            </p>
                            <p style="font-size:12px;
                                position: relative;
                                transform: translate(3%, 9%);">
                                <span style=" transform: translate(2%, 23%);display:inline-block;width:70px;"> Address</span><span style=" transform: translate(-12%, 20%);display:inline-block;width:191px;">: {{ $list->transports->origin_address }}</span>
                                <span style=" transform: translate(2%, 23%);display:inline-block;width:70px;"> Address</span><span style=" transform: translate(-12%, 20%);display:inline-block;width:200px;">: {{ $list->transports->destination_address}}</span>
                                {{-- <span style=" transform: translate(2%, 1%);display:inline-block;width:97px;"> Address</span><span style=" transform: translate(1%, 12%);display:inline-block;width:150px;">: {{ $list->transports->destination_address }}</span> --}}
                                {{-- <span style=" transform: translate(45%, 15%);display:inline-block;width:119px;"> Address</span>: {{ $list->transports->destination_address }} --}}
                            </p>
                            <p style="font-size:12px;
                                position: relative;
                                transform: translate(3%, 9%);">
                                <span style=" transform: translate(2%, 23%);display:inline-block;width:70px;"> City</span><span style=" transform: translate(-12%, 20%);display:inline-block;width:190px;">: {{ $list->transports->city_origin->name }}</span>
                                {{-- <span style=" transform: translate(11%, 23%);display:inline-block;width:119px;"> City</span>: {{ $list->transports->city_destination->name }} --}}
                                <span style=" transform: translate(2%, 23%);display:inline-block;width:70px;"> City</span><span style=" transform: translate(-12%, 20%);display:inline-block;width:190px;">: {{ $list->transports->city_destination->name}}</span>
                            </p>
                            <p style="font-size:12px;
                                position: relative;
                                transform: translate(3%, 9%);">
                                <span style=" transform: translate(2%, 23%);display:inline-block;width:70px;"> PIC</span><span style=" transform: translate(-12%, 20%);display:inline-block;width:190px;">: {{ $list->transports->pic_name_origin }} / {{ $list->transports->pic_phone_origin }}</span>
                                <span style=" transform: translate(2%, 23%);display:inline-block;width:70px;"> PIC</span><span style=" transform: translate(-12%, 20%);display:inline-block;width:190px;">: {{ $list->transports->pic_name_destination }} / {{ $list->transports->pic_phone_destination }} </span>
                                {{-- <span style=" transform: translate(3%, 30%);display:inline-block;width:97px;"> PIC</span>: {{ $list->transports->pic_name_origin }} / {{ $list->transports->pic_phone_origin }} --}}
                                {{-- <span style=" transform: translate(45%, 23%);display:inline-block;width:119px;"> PIC</span>: {{ $list->transports->pic_name_destination }} / {{ $list->transports->pic_phone_destination }} --}}
                            </p>
                    </td>
                    <td colspan="1">
                        <div style="position: relative;
                                transform: translate(1%, -50%);">
                            <div style="width:17px;margin-top:-4%;margin-left:7%;position:inherit;
                                height:15px;border-radius: 3px;border:solid 1px black;">
                                <p style="margin-top:-1.5%;margin-left:7%;text-align: center">L
                                </p>
                            </div>
                            <div style="width:17px;margin-top:-4%;margin-left:39%;position:inherit;
                            height:15px;border-radius: 3px;border:solid 1px black;">
                            <p style="margin-top:-1.5%;margin-left:5%;text-align: center">U
                            </p>
                        </div>
                            <div style="width:17px;margin-top:-4%;margin-left:70%;position:inherit;
                                height:15px;border-radius: 3px;border:solid 1px black;">
                                <p style="margin-top:-1.5%;margin-left:5%;text-align: center">D
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
      </table>
</body>
</html>