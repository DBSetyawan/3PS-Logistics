@extends('admin.layouts.master', array('detail_data_item_V'=> session()->get('detail_data_item_V')))
@section('head')
<link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" />
<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/bootstrap/css/bootstrap-fileupload.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
<link href="{{ asset('css/style.css') }}" rel="stylesheet" />
<link href="{{ asset('css/hunterPopup.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/like-yt.css') }}" />
<link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/gritter/css/jquery.gritter.css') }}" />
<link href="{{ asset('css/style-default.css') }}" rel="stylesheet" id="style_color" />
<link href="{{ asset('assets/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/select2.4.0.3/select2.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/uniform/css/uniform.default.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui-1.10.1.custom.min.css') }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.5/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/validationEngine.jquery.css">
@endsection
@section('brand')
<a class="brand" href="/home">
    {{--  <img src="../img/logo.png" alt="Tiga Permata System" />  --}}
</a>
@endsection
@section('breadcrumb')
<li>
    <a href="/home"><i class="icon-home"></i></a>
    <span class="divider">/</span>
</li>
<li>
    <a href="#">Vendor Item Transport List</a>
    <span class="divider">/</span>
</li>
<li class="active">
    {{ $menu}}
</li>
@endsection

@section('content')
<div id="main-content">
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
       <!-- BEGIN PAGE HEADER-->
       <div class="row-fluid">
          <div class="span12">
             <!-- BEGIN PAGE TITLE & BREADCRUMB-->
              <h3 class="page-title">
                   {{ $menu }}
              </h3>
              <ul class="breadcrumb">
                  @yield('breadcrumb')
              </ul>
              <!-- END PAGE TITLE & BREADCRUMB-->
          </div>
       </div>
       <!-- END PAGE HEADER-->

       <!-- BEGIN ADVANCED TABLE widget-->
       <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget red">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> {{ $menu }}</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                            <a href="javascript:;" class="icon-remove"></a>
                        </span>
                    </div>
                    <div class="widget-body">
                      @if ($errors->any())
                          <div class="alert alert-danger">
                              <strong>Whoops!</strong> There were some problems with your input.<br><br>
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                      @php
                      $var_checks = isset($find_i_customer->vendors->company_name) ? $find_i_customer->vendors->company_name : 'is_null';
                  @endphp
                  <div class="modal-footer">
                      FORM DETAIL VENDOR:&nbsp;<strong>{{ isset($find_i_customer->vendors->company_name) ? $find_i_customer->vendors->company_name : __('COMPANY - VENDOR') }}</strong>
                    </div>
                        <!-- BEGIN FORM-->
                <form class="form-horizontal" id="add_item_vendor">
                        <br />
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Item Code</label>
                            <div class="controls">
                                <input class="input-large validate[required]" disabled="true" type="text" maxlength="30" style="width:326px" id="itemcode" name="itemcode" value="{{ $find_i_customer->item_code }}" />
                                {{-- <span class="help-inline">Some hint here</span> --}}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Vendor</label>
                            <div class="controls">
                                <select class="input-large m-wrap validate[required] vens" style="width:340px" tabindex="1" id="vendorx" name="vendorx">
                                        @foreach($vendors as $a)
                                        <option value="{{ $a->id }}" @if($a->id==$find_i_customer->vendors['id']) selected='selected' @endif >{{ isset($find_i_customer->vendors->company_name) ? $find_i_customer->vendors->company_name : __('COMPANY - VENDOR') }}</option>
                                    @endforeach()
                            </select>
                        </div>
                    </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Sub Service</label>
                            <div class="controls">
                                <select class="dtsubservices input-large m-wrap validate[required]" style="width:340px" tabindex="1" id="sub_service_id" name="sub_service_id">
                                    @foreach($sub_service as $a)
                                    <option value="{{ $a->id }}" @if($a->id==$find_i_customer->sub_service_id) selected='selected' @endif >{{ $a->name }}</option>
                                @endforeach()
                                </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align: end">Shipment category</label>
                        <div class="controls">
                            <select class="dtshipmentctgry input-large m-wrap validate[required]" style="width:340px" tabindex="1" id="shipmentx" name="shipmentx">
                                    @foreach($shc as $a)
                                    <option value="{{ $a->id }}" @if($a->id==$find_i_customer->ship_category) selected='selected' @endif >{{ $a->nama }}</option>
                                @endforeach()
                        </select>
                    </div>
                </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align: end">Moda</label>
                        <div class="controls">
                            <select class="dtmoda input-large m-wrap validate[required]" style="width:340px" tabindex="1" id="moda_x" name="moda_x">
                                @foreach($Mds as $a)
                                    <option value="{{ $a->id }}" @if($a->id==$find_i_customer->moda) selected='selected' @endif >{{ $a->name }}</option>
                                @endforeach()
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="text-align: end">Origin</label>
                    <div class="controls">
                        <select class="citys input-large m-wrap validate[required]" style="width:340px" tabindex="1" id="originx" name="originx">
                            @foreach($Cty as $a)
                                <option value="{{ $a->id }}" @if($a->id==$find_i_customer->origin) selected='selected' @endif >{{ $a->name }}</option>
                            @endforeach()
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" style="text-align: end">Destination</label>
                <div class="controls">
                        <select class="citys input-large m-wrap validate[required]" style="width:340px" tabindex="1" id="destination_x" name="destination_x">
                            @foreach($Cty as $a)
                                <option value="{{ $a->id }}" @if($a->id==$find_i_customer->destination) selected='selected' @endif >{{ $a->name }}</option>
                            @endforeach()
                        </select>
                    </div>
                </div>
                    <div class="control-group">
                        <label class="control-label" style="text-align: end">Move Description</label>
                            <div class="controls">
                                <input disabled="true" class="input-large validate[required]" type="text" value="{{ $find_i_customer->itemovdesc }}" style="width:340px" id="itemovdesc" name="itemovdesc" />
                            </div>
                        </div>
                            <div class="control-group">
                                <label class="control-label" style="text-align: end">Unit</label>
                                <div class="controls">
                                     <input class="input-large validate[required]" type="text" maxlength="30" style="width:340px" value="{{ $find_i_customer->unit }}" id="unit" name="unit" />
                                    {{-- <span class="help-inline">Some hint here</span> --}}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Quantity</label>
                            <div class="controls">
                                <input class="input-large validate[required]" type="text" maxlength="30" style="width:340px" id="qty" name="qty" required/>
                                Saldo (Semua Gudang): <span id="ttlQty" class="add-on"></span><span id="ttl">{{ $pulltotalUnit1Quantity }}</span> {{ $CekSatuanBarang }}
                                    {{-- <span class="help-inline">Some hint here</span> --}}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" style="text-align: end">Price</label>
                            <div class="controls">
                            <input class="input-large validate[required]" type="text" maxlength="30" style="width:340px" name="price" id="price" value="{{ $find_i_customer->price }}" />
                                {{-- <span class="help-inline">Some hint here</span> --}}
                            </div>
                    </div>
                    </div>
                    @php
                        $idx_item_vendors = session()->get('idx_item_vendor');
                        $ekrips = \Illuminate\Support\Facades\Crypt::encrypt($idx_item_vendors);   
                    @endphp
                        <div class="modal-footer">
                            <button id="submitvendor" class="btn btn-primary">Update</button>
                            @if($idx_item_vendors == null)
                            <a class="btn btn-success" href="{{ route('datavendor.show', array(session()->get('id'))) }}">Back To List</a>
                                @else
                                <a class="btn btn-success" href="{{ route('add_item_vendor.added', array(session()->get('id'), $ekrips )) }}">Back To List</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
   </div>
</div>
@endsection
@section('javascript')
<script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
<script src="{{ asset('js/dupselect.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7/dist/sweetalert2.all.min.js"></script>
@include('sweetalert::view')
<!-- Load javascripts at bottom, this will reduce page load time -->
<script src="{{ asset('js/jquery-popup.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.blockui.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>

<script src="{{ asset('js/common-scripts.js') }}"></script>
<!--script for this page only-->
<script src="{{ asset('js/dynamic-table.js') }}"></script>
<script src="{{ asset('js/dynamic-table-rates.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-en.js" integrity="sha256-6mrxHx3BPUM9vJm3dH7jULYW56kexJcIO6LPneaBnS4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.js"
integrity="sha256-CGeJcrPLTi6rwHUfGazTyGhlRmLVJ4RIX79X1FmNQ3k=" crossorigin="anonymous"></script>
  <!-- END JAVASCRIPTS -->
   <script language="javascript" type="text/javascript">
       $('#destination_x').on('change', function(e){
                let destination = e.target.value;
                $.get('/loaded_auto_search_txt/find/'+ destination, function(data){
                    $.each(data, function(ix, ox){
                        $.get('/loaded_auto_search_txt/find/'+ $('#originx').val(), function(dax){
                            $.each(dax, function(ix, sdx){
                                $('#itemovdesc').val(''+'pengiriman'+' dari '+sdx.name+' ke '+ox.name);
                            });
                        });
                    })
                });
           });

           $(".vens option:not(:selected)").attr('disabled', true);
           $(".vens").select2();

           $(".dtsubservices option:not(:selected)").attr('disabled', true);
           $(".dtsubservices").select2();

           $(".dtshipmentctgry option:not(:selected)").attr('disabled', true);
           $(".dtshipmentctgry").select2();

           $(".dtmoda option:not(:selected)").attr('disabled', true);
           $(".dtmoda").select2();

           $(".citys option:not(:selected)").attr('disabled', true);
           $(".citys").select2();

        $(function(){
            $('#submitvendor').click(function (e) {
                e.preventDefault();
                $("#submitvendor").prop( "disabled", true );

                $("#submitvendor").text('processing..');
                    
                return new Promise((resolve, reject) => {
                    setTimeout(() => resolve(UpdateDataItemVendor()), 3500)
                    }
                );
            });
        });

        async function UpdateDataItemVendor() {
            
            const SuccessAlertsTransportAPI = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 7500
            })

            let itemcode = $("#itemcode").val();
            let vendorx = $("#vendorx").val();
            let sub_service_id = $("#sub_service_id").val();
            let shipmentx = $("#shipmentx").val();
            let moda_x = $("#moda_x").val();
            let unit = $("#unit").val();
            let originx = $("#originx").val();
            let qty = $("#qty").val();
            let destination_x = $("#destination_x").val();
            let itemovdesc = $("#itemovdesc").val();
            let price = $("#price").val();

                const apiItemVendors = "{{ route('update.data.item.vendors', ['branch_id' => $some, 'id'=> $find_i_customer->id ] ) }}";
                const dataItemVendors = { 

                        itemcode: itemcode,
                        vendorx: vendorx,
                        qty: qty,
                        sub_service_id: sub_service_id,
                        shipmentx: shipmentx,
                        moda_x: moda_x,
                        originx: originx,
                        destination_x: destination_x,
                        originx: originx,
                        itemovdesc: itemovdesc,
                        price: price,
                        unit: unit
                           
                    };

        try 
            {

                const responseVendors = await fetch(apiItemVendors, {

                        method: 'GET',
                        cache: 'no-cache',
                        credentials: 'same-origin',
                        redirect: 'follow',
                        referrer: 'no-referrer',
                        body: JSON.stringify(dataItemVendors),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json'
                    }

                });

                const dataJsonVendors = await responseVendors.json();
                let VendorsPromise = new Promise((resolve, reject) => {
                    setTimeout(() => resolve(dataJsonVendors), 1000)
                });
    
                    let VendorsPromises = await VendorsPromise;

                    $("#submitvendor").prop("disabled", false);
                    $("#submitvendor").text("Update");

            } 
                catch (errors) {
                  
                    $.ajaxSetup(
                                    {
                                        headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                            }
                        )
                    ;

                    let request = $.ajax({
                    
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: apiItemVendors,
                    type: "GET",
                    dataType: "json",
                    data: dataItemVendors,
                    success: function (data) {
                        Swal({
                            title: 'Accurate Cloud',
                            html: 'Kode Barang: <br/><pre>'+ data.idAccurateCloud + '</pre>\n' + 'Nama Item: <br/><pre>' + data.nameItem +
                            '</pre>\n'+ 'Saldo (Semua barang): <br/><code style="color: #006400">' + data.totalQuantity + '</code>',
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Tutup',
                        }).then((result) => {
                            if (result.value) {
                                let total = 0;
                                $('#ttl').each(function(){
                                    total += parseFloat(this.innerHTML);
                                });

                                const totalqty = parseFloat(total)+parseFloat(data.totalQuantity);
                                const callResponse = data.response;
                                const toast = Swal.mixin({
                                        toast: true,
                                        position: 'bottom-end',
                                        showConfirmButton: false,
                                        timer: 15000
                                    }
                                );

                                    $("#ttl").html(`<span id='ttl' class='add-on'>${totalqty}</span>`),
                                    $("#submitvendor").prop( "disabled", false ),
                                    $("#submitvendor").text('Update Vendor')
                                    
                                toast({
                                        title: `${callResponse}`
                                }
                            )
                        }
                    })
                },
                complete:function(data){
                 
                },
                    error: function(jqXhr, json, errorThrown){
                     
                        let responses = $.parseJSON(jqXhr.responseText).errors;
                            errorsHtml = '<div class="alert alert-danger"><ul>';
                        $.each( responses, function( key, value ) {
                                errorsHtml +=  value[0] +'<br/>';
                            }
                        );
                            errorsHtml += '</ul></div>';
                            buttonconfirm = '<div class="badge badge-info closeme" style="font-size:14px;height:19px;width:40px;cursor: pointer">Okay</div>';
                            let VendorsPromise = new Promise((resolve, reject) => {
                                setTimeout(() =>        
                                        Swal({
                                        title: "Code Error " + jqXhr.status + ': ' + errorThrown,
                                        text: "Maaf proses update data gagal diproses !",
                                            confirmButtonColor: '#3085d6',
                                            html: errorsHtml +'<br/>'+ buttonconfirm,
                                            width: 'auto',
                                            showConfirmButton: false,
                                            type: 'error'
                                        }).then((result) => {
                                        if (result.value) {
                                                return false;
                                    }
                            }),
                                $("#submitvendor").prop("disabled", false),
                                $("#submitvendor").text("Update Vendor"), 1000)
                        });
                    }
                }
            );
                
                //do something with request

                    // const ErrorsAlertsTransportAPI = Swal.mixin({
                    //     toast: true,
                    //     position: 'bottom-end',
                    //     showConfirmButton: false,
                    //     timer: 7000
                    // })

                    // let VendorsPromiseErrors = new Promise((resolve, reject) => {
                    //     setTimeout(() => reject(console.error('Error:', errors)), 2000)
                    // });

                        // ErrorsAlertsTransportAPI.fire({
                        //     type: 'error',
                        //     title: `Data gagal disimpan `+ errors
                        // })

                }

        }

        function total(arr) {
            if(!Array.isArray(arr)) return;
            return arr.reduce((a, v)=>a + v);
        }


   </script>
@endsection
