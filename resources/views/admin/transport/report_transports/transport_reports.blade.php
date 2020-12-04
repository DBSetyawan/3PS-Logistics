<!doctype html>
<html lang="en">

<head>
    {{-- https://icons8.com/icon/pack/beauty/color --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Surat Jalan #{{$data_transport->order_id}}</title>
    <style type="text/css">
        .watermark {
            background-image: url("{{ asset('img/dokumentback.png') }}");
            content: "";
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            position: absolute;
            z-index: -5;

            opacity: .3;
            transform: translate(200px, 400px), rotate(56deg);
        }

        .watermark:after {
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            border: 2px solid white;
            content: '';
            display: block;
        }

        .gray {
            background-color: lightslategray
        }

        table,
        th,
        td {
            padding: 1px;
            /* text-align: left; */
            font-size: 11px;
            font-family: Fira Code;
            border: 1.01px solid black;
            border-collapse: collapse;
            width: 100%;
            height: 1%;
            /* font-size: x-small; */
        }

        .page-break {
            page-break-after: always;
        }

        .container {
            width: 25%;
            height: 50px;
            overflow: hidden;
            position: relative;
        }

        .container-breaks {
            width: 25%;
            height: 20px;
            overflow: hidden;
            position: relative;
        }

        body {
            top: -67px;
            left: 0px;
            right: 0px;
            height: 60px;
            /* margin-top: 1%; */
            font-size: 10px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .tcLINE3P th,
        .tcLINE3P td {
            width: 125px;
            height: 35px;
        }

        .tcLINE3P th:first-child,
        .tcLINE3P td:first-child {
            width: 124.1px;
            height: 35px;

        }

        .tcLINE3P table {
            font-size: 14px;
            margin: 23px 1.5px -2.1px 1mm;
            margin-left:-2.15px;
            position:relative;
            /* border-left: .1px solid rgb(19, 19, 19); */
            border-bottom: .1px solid rgb(19, 19, 19);
            font-family: "Georgia", serif;
            line-height: 11px;
        }

        .underline {
            width: 100%;
            border-bottom: .1em dashed #000;
            text-align: center;
            line-height: 26px;
            position: relative;
        }

        .underline span {
            position: relative;
            bottom: 1px;
            height: 60px;
            padding: 0 340px 200px;
            background: #fff;
            font-size: 2px;
        }
    </style>
    {{-- <link href="https://fontawesome.com/v4.7.0/assets/font-awesome/css/font-awesome.css" rel="stylesheet"/> --}}
</head>

<body>
    <div style="margin-bottom:-1.5%;margin-right: 2%;font-size:20px;text-align:right;">SHIPPER</div>
    <div style="position: relative;font-size:13px;text-align:left;">{{ $now }}</div>
    <table>
        <tr>
            <th colspan="16">
                @if($data_transport->by_users =="146584")
                <img style="
                overflow: auto;
                margin-left:2px;
                margin-right: 2px;" width="80" HSPACE="17" VSPACE="20" align="left" align="left"
                    src="{{asset('./img/3pe-ls.png')}}" />
                <font style="font-family: Arial;position:absolute;">
                    Represented By
                    <br />
                    <font style="font-size: 13px;">
                        {{ $data_transport->company_branch->company->name }}
                    </font>
                    <br />
                    {{ $data_transport->company_branch->address }},
                    <br />
                    Tel: {{ $data_transport->company_branch->telp }}
                    <br />
                    Email: info@3permata.co.id
                </font>
                @else
                <img style="
                overflow: auto;
                margin-left:2px;
                margin-right: 2px;" HSPACE="14" VSPACE="15" align="left"
                    src="{{asset('./img/3pl-ls-ico.png')}}" />
                <font style="font-family: Arial;position:absolute;">
                    Represented By
                    <br />
                    <font style="font-size: 13px;">
                        {{ $data_transport->company_branch->company->name }}
                    </font>
                    <br />
                    {{ $data_transport->company_branch->address }}
                    <br />
                    Tel: {{ $data_transport->company_branch->telp }} 
                    <br />
                    Email: info@3permata.co.id
                </font>
                @endif
            </th>
            <th colspan="2">

                <span style="position: relative">Shipment Code :</span>
                <font
                    style="font-family: Fira Code;font-size: 15px;position: relative;transform: translate(-76px, 18px);">
                    * {{$data_transport->order_id}} *</font>

                {{-- <hr > --}}
                <div class="tcLINE3P">
                    <table style="width:102.05%;position:relative">
                        @if($data_transport->by_users =="146584")
                        <td>
                            CreatedAt : <br />
                            <font
                                style="font-family: Fira Code;font-size: 11px;position:absolute;transform: translate(1%, -7px);width: 107px">
                                {{$data_transport->created_at->format('d M Y H:i')}} </font>

                        </td>
                        @else
                        <td>
                            CreatedAt : <br />
                            <font
                                style="font-family: Fira Code;font-size: 11px;position:absolute;transform: translate(1%,1px);width: 100px">
                                {{$data_transport->created_at->format('d M Y H:i')}} </font>
                        </td>
                        @endif
                        <td>
                            Service : <br />
                            <p style="position: absolute;transform:translate(-1%, 2px)">
                                {{ $data_transport->itemtransports->sub_services->name }}
                            </p>
                        </td>
                    </table>

                </div>
                {{-- <span style=" border-width:43px;position: relative;
                border-bottom-style:solid;
                transform: translate(40%, -10%);">
                    {{-- Created At --}}
                {{-- </span>  --}}
                {{-- <font style="transform: translate(-41%, 1%);">
                        Created At
                    </font> 
                    <font style="font-family: Fira Code;font-size: 11px"> {{$data_transport->created_at->format('d M Y H:i')}}
                </font> --}}
                {{-- <p style="transform: translate(-41%, -50%);">
                    <span style="display:inline-block;width:150px"></span>Shipment Code:
                    <span style="display:inline-block;width:90px"></span><font style="font-family: Fira Code;font-size: 13px"> {{$data_transport->order_id}}
                </font>
                </p>
                <font style="transform: translate(-41%, 1%);">
                    Created At
                    <font style="font-family: Fira Code;font-size: 11px">
                        {{$data_transport->created_at->format('d M Y H:i')}} </font>
                </font>
                <img style="
                    margin-top: -61px;
                    margin-right: -7px;" height="56" width="58" HSPACE="10" VSPACE="2" align="right"
                    src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" /> --}}
            </th>

            {{--  <th style="height:79px" colspan="1">
                <table style="width:80.1%">
                    <td colspan="1" style="padding: 29px 9px;position: relative;
                           transform: translate(-0.05mm, 3px);">
                        <img style="
                    margin-top: -28px;position: relative;
                    margin-right: -2px;" height="56" width="50" HSPACE="3" VSPACE="2" align="right"
                            src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" />
                    </td>
                </table>

            </th>  --}}
             <th style="height:79px" colspan="1">
                <table style="width:80.1%">
                    <td colspan="1" style="padding: 29px 9px;position: relative;
                           transform: translate(-0.05mm, 3px);">
                        <img style="
                    margin-top: -28px;position: relative;
                    margin-right: -2px;" height="56" width="50" HSPACE="3" VSPACE="2" align="right"
                            src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" />
                    </td>
                </table>

            </th>
            {{-- <p style="transform: translate(1%, -90%);">
                    Service: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {{$data_transport->itemtransports->sub_services->name}}
            </p> --}}
        </tr>
        <tr>
            <td colspan="16" style="position: relative;">Customer : {{ $data_transport->customers->name }}</td>
            {{-- <td ></td>
                    <td ></td> --}}
            <td>collie</td>
            <td>Actual (Kg)</td>
            <td>Chargeable (Kg)</td>
        </tr>
        <tr>
            <td colspan="12" style="width:186px;position:absolute;">Origin : {{$data_transport->city_origin->citys->name}}</td>
            {{-- <td></td> --}}
            <td colspan="4" style="width:186px;position:absolute;">Destination : {{$data_transport->city_destination->citys->name}}</td>
            <td>{{$data_transport->collie}}</td>
            <td>{{$data_transport->actual_weight}}</td>
            <td colspan="1">{{$data_transport->chargeable_weight}}</td>
        </tr>
        <tr>
            <td colspan="16" style="position: relative">
                <p align="top">
                <p style="
                    position: relative;
                    transform: translate(1%, -1%);">
                </p>
                <span style=" transform: translate(1%, 60%);display:inline-block;width:102px;"> Shipper's
                    Details</span><span style=" transform: translate(1%, 60%);display:inline-block;width:200px;">:
                    {{ $data_transport->customers->name}}</span>
                <p style="
                    position: relative;
                    transform: translate(1%, -1%);">
                </p>
                <span style=" transform: translate(1%, 84%);display:inline-block;width:102px;"> Address</span><span
                    style=" transform: translate(1%, 84%);display:inline-block;width: 226px">:
                    {{ $data_transport->origin_address }}</span>
                <p style="
                    position: relative;
                    transform: translate(1%, -1%);"><span
                        style=" transform: translate(-3%, 90%);display:inline-block;width:102px;"> Attn:</span><span
                        style=" transform: translate(-42%, 90%);display:inline-block;width:190px;">
                        {{$data_transport->pic_name_origin}} <span
                            style=" transform: translate(10%, 20%);display:inline-block;width:190px;">Telp :
                            {{$data_transport->pic_phone_origin}}</span>
                </p>
                {{-- <span style=" transform: translate(1%, 70%);display:inline-block;width:113px;"> PIC:</span><span style=" transform: translate(-42%, 70%);display:inline-block;width:220px;">  {{$data_transport->pic_name_origin}}</span>
                <span style=" transform: translate(-210%, 70%);display:inline-block;width:113px;"> Telp</span><span
                    style=" transform: translate(-270%, 70%);display:inline-block;width:120px;">:
                    {{$data_transport->pic_phone_origin}}</span> --}}

            </td>
            <td colspan="3">
                <p align="top" style="position: relative">
                <p style="
                        position: relative;
                        transform: translate(1%, -20%);">
                </p>
                <span style=" transform: translate(1%, 60%);display:inline-block;width:114px;"> Consignee
                    Details</span><span style=" transform: translate(1%, 60%);display:inline-block;width:219px;">:
                    {{$data_transport->destination_details}} </span>
                <p style="
                        position: relative;
                        transform: translate(1%, -20%);">
                </p>
                <span style=" transform: translate(1%, 84%);display:inline-block;width:114px;"> Address</span><span
                    style=" transform: translate(1%, 84%);display:inline-block;width: 199px">:

                    {{ $data_transport->destination_address }} </span>
                <p style="
                        position: relative;
                        transform: translate(1%, -20%);"><span
                        style=" transform: translate(-2%, 90%);display:inline-block;width:113px;"> PIC:</span><span
                        style=" transform: translate(-43%, 90%);display:inline-block;width:220px;">
                        {{$data_transport->pic_name_destination}} <span
                            style=" transform: translate(20%, 20%);display:inline-block;width:220px;">Telp :
                            {{$data_transport->pic_phone_destination}}</span>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="16">PO Codes: {{$data_transport->purchase_order_customer}}</td>
            {{--  <td width="1%"colspan="3">Note: {{$data_transport->notes}}</td> --}}
            <td colspan="3">Note:</td>
        </tr>
        <tr>
            <td colspan="14">
                <p align="top">
                <p style="
                            position: relative;
                            transform: translate(1%, -16%);">Signature (Shipper)
                </p>
                <p style="
                            position: relative;
                            transform: translate(1%, 10%);">Name:
                </p>
                <p style="
                            position: relative;
                            transform: translate(1%, 100%);">Date:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Time:
                </p>
            </td>
            <td colspan="3">
                <p align="top">
                <p style="
                                position: relative;
                                transform: translate(1%, -16%);">Signature (Courier)
                </p>
                <p style="
                                position: relative;
                                transform: translate(1%, -20%);">Name:
                </p>
                <p style="
                                position: relative;
                                transform: translate(1%, 100%);">Date:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Time:
                </p>
            </td>
            <td colspan="2">
                <p align="top">
                <p style="
                                    position: relative;
                                    transform: translate(1%, -16%);">Signature (Receiver)
                </p>
                <p style="
                                    position: relative;
                                    transform: translate(1%, -20%);">Name:
                </p>
                <p style="
                                    position: relative;
                                    transform: translate(1%, 100%);">Date:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Time:
                </p>
            </td>
        </tr>
        {{-- <tr>
                <td style="height:10px;background-color: #b0b1b2;"colspan="19"><font style="font-size:11px">I/We hereby acknowledge all the terms & condition stated on the reverse side as the terms & conditon of this contract and agree to be bound by</font></td>
            </tr> --}}
    </table>

    <div class="underline">
        <span>
            <img src="https://img.icons8.com/ios/48/000000/barber-scissors.png" style="
            float: right;
            width: 26px;
            transform: translate(1%, 100%);
            height: 17px;
        " />
        </span>
    </div>

    <div style="margin-bottom:-1.5%;margin-right: 2%;font-size:20px;text-align:right;">COURIER</div>
    <img class=" watermark" src="{{ asset('img/dokumentback.png') }}">
    {{-- sadadasd --}}

    <div style="position: relative;font-size:13px;text-align:left;">{{ $now }}</div>
    <table style="position: relative">
        <tr>
            <th colspan="16">
                @if($data_transport->by_users=="146584")
                <img style="
                overflow: auto;
                margin-left:2px;
                margin-right: 2px;" width="80" HSPACE="17" VSPACE="20" align="left" align="left"
                src="{{asset('./img/3pe-ls.png')}}" />
                <font style="font-family: Arial;position:absolute;">
                    Represented By
                    <br />
                    <font style="font-size: 13px;">
                        {{ $data_transport->company_branch->company->name }}
                    </font>
                    <br />
                    {{ $data_transport->company_branch->address }},
                    <br />
                    Tel: {{ $data_transport->company_branch->telp }}
                    <br />
                    Email: info@3permata.co.id
                </font>
                @else
                <img style="
                overflow: auto;
                margin-left:2px;
                margin-right: 2px;" HSPACE="14" VSPACE="15" align="left"
                    src="{{asset('./img/3pl-ls-ico.png')}}" />
                <font style="font-family: Arial;position:absolute;">
                    Represented By
                    <br />
                    <font style="font-size: 13px;">
                        {{ $data_transport->company_branch->company->name }}
                    </font>
                    <br />
                    {{ $data_transport->company_branch->address }}
                    <br />
                    Tel: {{ $data_transport->company_branch->telp }}
                    <br />
                    Email: info@3permata.co.id
                </font>
                @endif
            </th>
            <th colspan="2">

                <span style="position: relative">Shipment Code :</span>
                <font
                    style="font-family: Fira Code;font-size: 15px;position: relative;transform: translate(-76px, 18px);">
                    * {{$data_transport->order_id}} *</font>

                {{-- <hr > --}}
                <div class="tcLINE3P">
                    <table style="width:102.1%;position:relative">

                        @if($data_transport->by_users =="146584")
                        <td>
                            CreatedAt : <br />
                            <font
                                style="font-family: Fira Code;font-size: 11px;position:absolute;transform: translate(1%, -8px);width: 100px">
                                {{$data_transport->created_at->format('d M Y H:i')}} </font>
                        </td>
                        @else
                        <td>
                            CreatedAt : <br />
                            <font
                                style="font-family: Fira Code;font-size: 11px;position:absolute;transform: translate(1%, 1px);width: 100px">
                                {{$data_transport->created_at->format('d M Y H:i')}} </font>
                        </td>
                        @endif
                        <td>
                            Service : <br />
                            <p style="position: absolute;transform:translate(-1%, 2px)">
                                {{ $data_transport->itemtransports->sub_services->name }}
                            </p>
                        </td>
                    </table>

                </div>
                {{-- <span style=" border-width:43px;position: relative;
                border-bottom-style:solid;
                transform: translate(40%, -10%);">
                    {{-- Created At --}}
                {{-- </span>  --}}
                {{-- <font style="transform: translate(-41%, 1%);">
                        Created At
                    </font> 
                    <font style="font-family: Fira Code;font-size: 11px"> {{$data_transport->created_at->format('d M Y H:i')}}
                </font> --}}
                {{-- <p style="transform: translate(-41%, -50%);">
                    <span style="display:inline-block;width:150px"></span>Shipment Code:
                    <span style="display:inline-block;width:90px"></span><font style="font-family: Fira Code;font-size: 13px"> {{$data_transport->order_id}}
                </font>
                </p>
                <font style="transform: translate(-41%, 1%);">
                    Created At
                    <font style="font-family: Fira Code;font-size: 11px">
                        {{$data_transport->created_at->format('d M Y H:i')}} </font>
                </font>
                <img style="
                    margin-top: -61px;
                    margin-right: -7px;" height="56" width="58" HSPACE="10" VSPACE="2" align="right"
                    src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" /> --}}
            </th>

            {{--  <th style="height:78px" colspan="1">
                <table style="width:80.1%">
                    <td colspan="1" style="padding: 29px 3px;position: relative;
                           transform: translate(13px, 2px);">
                        <img style="
                    margin-top: -28px;position: relative;
                    margin-right: 12px;" height="56" width="70" HSPACE="3" VSPACE="2" align="right"
                            src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" />
                    </td>
                </table>

            </th>  --}}
             <th style="height:79px" colspan="1">
                <table style="width:80.1%">
                    <td colspan="1" style="padding: 29px 9px;position: relative;
                           transform: translate(-0.05mm, 3px);">
                        <img style="
                    margin-top: -28px;position: relative;
                    margin-right: -2px;" height="56" width="50" HSPACE="3" VSPACE="2" align="right"
                            src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" />
                    </td>
                </table>

            </th>
            {{-- <p style="transform: translate(1%, -90%);">
                    Service: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {{$data_transport->itemtransports->sub_services->name}}
            </p> --}}
        </tr>
        <tr>
            <td colspan="16">Customer : {{ $data_transport->customers->name }}</td>
            {{-- <td ></td>
                    <td ></td> --}}
            <td>collie</td>
            <td>Actual (Kg)</td>
            <td>Chargeable (Kg)</td>
        </tr>
        <tr>
            {{--  <td colspan="12">Origin : {{$data_transport->origin_details }}</td>  --}}
            {{-- <td></td> --}}
            {{--  <td colspan="4">Destination : {{$data_transport->destination_details}}</td>  --}}
              <td colspan="12" style="width:186px;position:absolute;">Origin : {{$data_transport->city_origin->citys->name}}</td>
            {{-- <td></td> --}}
            <td colspan="4" style="width:186px;position:absolute;">Destination : {{$data_transport->city_destination->citys->name}}</td>
            <td>{{$data_transport->collie}}</td>
            <td>{{$data_transport->actual_weight}}</td>
            <td colspan="1">{{$data_transport->chargeable_weight}}</td>
        </tr>
        <tr>
           <td colspan="16" style="position: relative">
                <p align="top">
                <p style="
                    position: relative;
                    transform: translate(1%, -1%);">
                </p>
                <span style=" transform: translate(1%, 60%);display:inline-block;width:102px;"> Shipper's
                    Details</span><span style=" transform: translate(1%, 60%);display:inline-block;width:200px;">:
                    {{ $data_transport->customers->name}}</span>
                <p style="
                    position: relative;
                    transform: translate(1%, -1%);">
                </p>
                <span style=" transform: translate(1%, 84%);display:inline-block;width:102px;"> Address</span><span
                    style=" transform: translate(1%, 84%);display:inline-block;width: 226px">:
                    {{ $data_transport->origin_address }}</span>
                <p style="
                    position: relative;
                    transform: translate(1%, -1%);"><span
                        style=" transform: translate(-3%, 90%);display:inline-block;width:102px;"> Attn:</span><span
                        style=" transform: translate(-42%, 90%);display:inline-block;width:190px;">
                        {{$data_transport->pic_name_origin}} <span
                            style=" transform: translate(10%, 20%);display:inline-block;width:190px;">Telp :
                            {{$data_transport->pic_phone_origin}}</span>
                </p>
                {{-- <span style=" transform: translate(1%, 70%);display:inline-block;width:113px;"> PIC:</span><span style=" transform: translate(-42%, 70%);display:inline-block;width:220px;">  {{$data_transport->pic_name_origin}}</span>
                <span style=" transform: translate(-210%, 70%);display:inline-block;width:113px;"> Telp</span><span
                    style=" transform: translate(-270%, 70%);display:inline-block;width:120px;">:
                    {{$data_transport->pic_phone_origin}}</span> --}}

            </td>
            <td colspan="3">
                <p align="top">
                <p style="
                        position: relative;
                        transform: translate(1%, -20%);">
                </p>
                <span style=" transform: translate(1%, 60%);display:inline-block;width:114px;"> Consignee
                    Details</span><span style=" transform: translate(1%, 60%);display:inline-block;width:219px;">:
                    {{$data_transport->destination_details}} </span>
                <p style="
                        position: relative;
                        transform: translate(1%, -20%);">
                </p>
                <span style=" transform: translate(1%, 84%);display:inline-block;width:114px;"> Address</span><span
                    style=" transform: translate(1%, 84%);display:inline-block;width:219px;">:
                    {{ $data_transport->destination_address }} </span>
                <p style="
                        position: relative;
                        transform: translate(1%, -20%);"><span
                        style=" transform: translate(-2%, 90%);display:inline-block;width:113px;"> PIC:</span><span
                        style=" transform: translate(-43%, 90%);display:inline-block;width:220px;">
                        {{$data_transport->pic_name_destination}} <span
                            style=" transform: translate(20%, 20%);display:inline-block;width:220px;">Telp :
                            {{$data_transport->pic_phone_destination}}</span>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="16">PO Codes: {{$data_transport->purchase_order_customer}}</td>
            {{--  <td width="1%"colspan="3">Note: {{$data_transport->notes}}</td> --}}
            <td colspan="3">Note:</td>
        </tr>
        <tr>
            <td colspan="14">
                <p align="top">
                <p style="
                            position: relative;
                            transform: translate(1%, -16%);">Signature (Shipper)
                </p>
                <p style="
                            position: relative;
                            transform: translate(1%, -20%);">Name:
                </p>
                <p style="
                            position: relative;
                            transform: translate(1%, 100%);">Date:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Time:
                </p>
            </td>
            <td colspan="3">
                <p align="top">
                <p style="
                                position: relative;
                                transform: translate(1%, -16%);">Signature (Courier)
                </p>
                <p style="
                                position: relative;
                                transform: translate(1%, -20%);">Name:
                </p>
                <p style="
                                position: relative;
                                transform: translate(1%, 100%);">Date:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Time:
                </p>
            </td>
            <td colspan="2">
                <p align="top">
                <p style="
                                    position: relative;
                                    transform: translate(1%, -16%);">Signature (Receiver)
                </p>
                <p style="
                                    position: relative;
                                    transform: translate(1%, -20%);">Name:
                </p>
                <p style="
                                    position: relative;
                                    transform: translate(1%, 100%);">Date:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Time:
                </p>
            </td>
        </tr>
        {{-- <tr>
                <td style="height:10px;background-color: #b0b1b2;"colspan="19"><font style="font-size:11px">I/We hereby acknowledge all the terms & condition stated on the reverse side as the terms & conditon of this contract and agree to be bound by</font></td>
            </tr> --}}
    </table>

    <div class="underline">
        <span>
            <img src="https://img.icons8.com/ios/48/000000/barber-scissors.png" style="
            float: right;
            width: 26px;
            transform: translate(1%, 90%);
            height: 17px;
        " />
        </span>
    </div>
    <div style="margin-bottom:-1.5%;margin-right: 2%;font-size:20px;text-align:right;">RECEIVER</div>
    <div style="position: relative;font-size:13px;text-align:left;">{{ $now }}</div>
    <table>
        <tr>
            <th colspan="16">
                @if($data_transport->by_users == "146584")
                <img style="
                overflow: auto;
                margin-left:2px;
                margin-right: 2px;" width="80" HSPACE="17" VSPACE="20" align="left" align="left"
                src="{{asset('./img/3pe-ls.png')}}" />
                <font style="font-family: Arial;position:absolute;">
                    Represented By
                    <br />
                    <font style="font-size: 13px;">
                        {{ $data_transport->company_branch->company->name }}
                    </font>
                    <br />
                    {{ $data_transport->company_branch->address }}
                    <br />
                    Tel: {{ $data_transport->company_branch->telp }}
                    <br />
                    Email: info@3permata.co.id
                </font>
                @else
                <img style="
                overflow: auto;
                margin-left:2px;
                margin-right: 2px;" HSPACE="14" VSPACE="15" align="left"
                    src="{{asset('./img/3pl-ls-ico.png')}}" />
                <font style="font-family: Arial;position:absolute;">
                    Represented By
                    <br />
                    <font style="font-size: 13px;">
                        {{ $data_transport->company_branch->company->name }}
                    </font>
                    <br />
                    {{ $data_transport->company_branch->address }}
                    <br />
                    Tel: {{ $data_transport->company_branch->telp }}
                    <br />
                    Email: info@3permata.co.id
                </font>
                @endif
            </th>
            <th colspan="2">

                <span style="position: relative">Shipment Code :</span>
                <font
                    style="font-family: Fira Code;font-size: 15px;position: relative;transform: translate(-76px, 18px);">
                    * {{$data_transport->order_id}} *</font>

                {{-- <hr > --}}
                <div class="tcLINE3P">
                                        <table style="width:102.1%;position:relative">

                        @if($data_transport->by_users =="146584")
                        <td>
                            CreatedAt : <br />
                            <font
                                style="font-family: Fira Code;font-size: 11px;position:absolute;transform: translate(1%, -10px);width: 100px">
                                {{$data_transport->created_at->format('d M Y H:i')}} </font>
                        </td>
                        @else
                        <td>
                            CreatedAt : <br />
                            <font
                                style="font-family: Fira Code;font-size: 11px;position:absolute;transform: translate(1%, 1px);width: 100px">
                                {{$data_transport->created_at->format('d M Y H:i')}} </font>
                        </td>
                        @endif
                        <td>
                            Service : <br />
                            <p style="position: absolute;transform:translate(-1%, 2px)">
                                {{ $data_transport->itemtransports->sub_services->name }}
                            </p>

                        </td>
                    </table>

                </div>
                {{-- <span style=" border-width:43px;position: relative;
                border-bottom-style:solid;
                transform: translate(40%, -10%);">
                    {{-- Created At --}}
                {{-- </span>  --}}
                {{-- <font style="transform: translate(-41%, 1%);">
                        Created At
                    </font> 
                    <font style="font-family: Fira Code;font-size: 11px"> {{$data_transport->created_at->format('d M Y H:i')}}
                </font> --}}
                {{-- <p style="transform: translate(-41%, -50%);">
                    <span style="display:inline-block;width:150px"></span>Shipment Code:
                    <span style="display:inline-block;width:90px"></span><font style="font-family: Fira Code;font-size: 13px"> {{$data_transport->order_id}}
                </font>
                </p>
                <font style="transform: translate(-41%, 1%);">
                    Created At
                    <font style="font-family: Fira Code;font-size: 11px">
                        {{$data_transport->created_at->format('d M Y H:i')}} </font>
                </font>
                <img style="
                    margin-top: -61px;
                    margin-right: -7px;" height="56" width="58" HSPACE="10" VSPACE="2" align="right"
                    src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" /> --}}
            </th>

            {{--  <th style="height:78px" colspan="1">
                <table style="width:80.1%">
                    <td colspan="1" style="padding: 29px 3px;position: relative;
                           transform: translate(13px, 2px);">
                        <img style="
                    margin-top: -28px;position: relative;
                    margin-right: 12px;" height="56" width="70" HSPACE="3" VSPACE="2" align="right"
                            src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" />
                    </td>
                </table>

            </th>  --}}
               <th style="height:79px" colspan="1">
                <table style="width:80.1%">
                    <td colspan="1" style="padding: 29px 9px;position: relative;
                           transform: translate(-0.05mm, 3px);">
                        <img style="
                    margin-top: -28px;position: relative;
                    margin-right: -2px;" height="56" width="50" HSPACE="3" VSPACE="2" align="right"
                            src="data:{{$qrCode->getContentType().";base64,".$qrCode->generate()}}" />
                    </td>
                </table>

            </th>
            {{-- <p style="transform: translate(1%, -90%);">
                    Service: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {{$data_transport->itemtransports->sub_services->name}}
            </p> --}}
        </tr>
        <tr>
            <td colspan="16">Customer : {{ $data_transport->customers->name }}</td>
            {{-- <td ></td>
                    <td ></td> --}}
            <td>collie</td>
            <td>Actual (Kg)</td>
            <td>Chargeable (Kg)</td>
        </tr>
        <tr>
            {{--  <td colspan="12">Origin : {{$data_transport->origin_details}}</td>  --}}
            {{-- <td></td> --}}
            {{--  <td colspan="4">Destination : {{$data_transport->destination_details}}</td>  --}}
              <td colspan="12" style="width:186px;position:absolute;">Origin : {{$data_transport->city_origin->citys->name}}</td>
            {{-- <td></td> --}}
            <td colspan="4" style="width:186px;position:absolute;">Destination : {{$data_transport->city_destination->citys->name}}</td>
            <td>{{$data_transport->collie}}</td>
            <td>{{$data_transport->actual_weight}}</td>
            <td colspan="1">{{$data_transport->chargeable_weight}}</td>
        </tr>
        <tr>
           <td colspan="16" style="position: relative">
                <p align="top">
                <p style="
                    position: relative;
                    transform: translate(1%, -1%);">
                </p>
                <span style=" transform: translate(1%, 60%);display:inline-block;width:102px;"> Shipper's
                    Details</span><span style=" transform: translate(1%, 60%);display:inline-block;width:200px;">:
                    {{ $data_transport->customers->name}}</span>
                <p style="
                    position: relative;
                    transform: translate(1%, -1%);">
                </p>
                <span style=" transform: translate(1%, 84%);display:inline-block;width:102px;"> Address</span><span
                    style=" transform: translate(1%, 84%);display:inline-block;width: 226px">:
                    {{ $data_transport->origin_address }}</span>
                <p style="
                    position: relative;
                    transform: translate(1%, -1%);"><span
                        style=" transform: translate(-3%, 90%);display:inline-block;width:102px;"> Attn:</span><span
                        style=" transform: translate(-42%, 90%);display:inline-block;width:190px;">
                        {{$data_transport->pic_name_origin}} <span
                            style=" transform: translate(10%, 20%);display:inline-block;width:190px;">Telp :
                            {{$data_transport->pic_phone_origin}}</span>
                </p>
                {{-- <span style=" transform: translate(1%, 70%);display:inline-block;width:113px;"> PIC:</span><span style=" transform: translate(-42%, 70%);display:inline-block;width:220px;">  {{$data_transport->pic_name_origin}}</span>
                <span style=" transform: translate(-210%, 70%);display:inline-block;width:113px;"> Telp</span><span
                    style=" transform: translate(-270%, 70%);display:inline-block;width:120px;">:
                    {{$data_transport->pic_phone_origin}}</span> --}}

            </td>
            <td colspan="3">
                <p align="top">
                <p style="
                        position: relative;
                        transform: translate(1%, -1%);">
                </p>
                <span style=" transform: translate(1%, 60%);display:inline-block;width:114px;"> Consignee
                    Details</span><span style=" transform: translate(1%, 60%);display:inline-block;width:219px;">:
                    {{$data_transport->destination_details}} </span>
               <p style="
                    position: relative;
                    transform: translate(1%, -1%);">
                </p>
                <span style=" transform: translate(1%, 84%);display:inline-block;width:114px;"> Address</span><span
                    style=" transform: translate(1%, 84%);display:inline-block;width:219px;">:
                    {{ $data_transport->destination_address }} </span>
                <p style="
                        position: relative;
                        transform: translate(1%, -20%);"><span
                        style=" transform: translate(-2%, 90%);display:inline-block;width:113px;"> PIC:</span><span
                        style=" transform: translate(-43%, 90%);display:inline-block;width:220px;">
                        {{$data_transport->pic_name_destination}} <span
                            style=" transform: translate(20%, 20%);display:inline-block;width:220px;">Telp :
                            {{$data_transport->pic_phone_destination}}</span>
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="16">PO Codes: {{$data_transport->purchase_order_customer}}</td>
            {{--  <td width="1%"colspan="3">Note: {{$data_transport->notes}}</td> --}}
            <td colspan="3">Note:</td>
        </tr>
        <tr>
            <td colspan="14">
                <p align="top">
                <p style="
                            position: relative;
                            transform: translate(1%, -16%);">Signature (Shipper)
                </p>
                <p style="
                            position: relative;
                            transform: translate(1%, -20%);">Name:
                </p>
                <p style="
                            position: relative;
                            transform: translate(1%, 100%);">Date:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Time:
                </p>
            </td>
            <td colspan="3">
                <p align="top">
                <p style="
                                position: relative;
                                transform: translate(1%, -16%);">Signature (Courier)
                </p>
                <p style="
                                position: relative;
                                transform: translate(1%, -20%);">Name:
                </p>
                <p style="
                                position: relative;
                                transform: translate(1%, 100%);">Date:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Time:
                </p>
            </td>
            <td colspan="2">
                <p align="top">
                <p style="
                                    position: relative;
                                    transform: translate(1%, -16%);">Signature (Receiver)
                </p>
                <p style="
                                    position: relative;
                                    transform: translate(1%, -20%);">Name:
                </p>
                <p style="
                                    position: relative;
                                    transform: translate(1%, 100%);">Date:
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Time:
                </p>
            </td>
        </tr>
        {{-- <tr>
                <td style="height:10px;background-color: #b0b1b2;"colspan="19"><font style="font-size:11px">I/We hereby acknowledge all the terms & condition stated on the reverse side as the terms & conditon of this contract and agree to be bound by</font></td>
            </tr> --}}
    </table>
</body>

</html>