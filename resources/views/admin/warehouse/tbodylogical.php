<tbody>
                                            @for ($i = 0; $i < $id_auto; $i++)
                                                @foreach($warehouseTolist as $list_customer)
                                                    <tr class="odd gradeX">
                                                        {{-- @if($api_v2 =="true")
                                                        <td style="width: 3%;"><input class="{{++$i}}" type="checkbox" id="check_sales_order[]" name="check_sales_order[]" value="{{$list_customer->id}}"></td>
                                                        @else
                                                            <td style="width: 2%;"><center><span style='background-color:TOMATO' class='label'>Disabled</span></center></td>
                                                        @endif --}}
                                                        <td style="width: 11%;">{{$list_customer->order_id}}</td>
                                                        <td style="width: 16%;">{{$list_customer->customers_warehouse->name}}</td>
                                                        <td style="width: 12%;">{{$list_customer->sub_service->name}}</td>
                                                        <td style="width: 10%;">{{$list_customer->contract_no}}</td>
                                                        <td style="width: 7%;">{{$list_customer->volume}}</td>
                                                        <td style="width: 7%;">{{number_format($list_customer->rate,0)}}</td>
                                                        <td style="width: 7%;">{{number_format($list_customer->total_rate,0)}}</td>
                                                        <td style="width: 7%;">{{$list_customer->created_at}}</td>
                                                        {{-- <td style="width: 7%;">{{$list_customer->users['name']}}</td> --}}
                                                        @if ($list_customer->warehouse_o_status->status_name == 'draft')
                                                        <td style="width: 5%;">
                                                                <span>
                                                                    <button id="draftds" style="background-color:gray;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                        data-id="{{ $list_customer->order_id }}"
                                                                        data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                        data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                        {{$list_customer->warehouse_o_status->status_name}}
                                                                    </button>
                                                                </span>
                                                            </td>
                                                            @else
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'process')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button style="background-color:GOLD;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $list_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'invoice')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button style="background-color:DODGERBLUE;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $list_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                            @else
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'done')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button id="dones" style="background-color:green;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $lsist_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                            @else
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'cancel')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button id="cancels" style="background-color:red;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $list_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                            @else
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'pod')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button id="pods" style="background-color:brown;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $list_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                            @else
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'paid')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button style="background-color:green;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $list_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" style data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                            @else
                                                        @endif
                                                        @if ($list_customer->warehouse_o_status->status_name == 'upload')
                                                        <td style="width: 5%;">
                                                            <span>
                                                                <button id="uploaded" style="background-color:orange;color:white" class="btn popovers btn-small ModalShowDataHistoryOrder" 
                                                                    data-id="{{ $list_customer->order_id }}" 
                                                                    data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                    {{$list_customer->warehouse_o_status->status_name}}
                                                                </button>
                                                            </span>
                                                        </td>
                                                            @else
                                                        @endif
                                                        @php
                                                            $encrypts = \Illuminate\Support\Facades\Crypt::encrypt($list_customer->id);   
                                                        @endphp
                                                        <td style="width: 9%;">
                                                                @if ($list_customer->warehouse_o_status->status_name == 'draft')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $encrypts)) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail ordercx" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    {{-- <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div> --}}
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    {{-- <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-id="{{ $list_customer->id }}" 
                                                                                data-target="#ModalStatusOrder" data-toggle="modal" data-original-title="Status Order"
                                                                                data-trigger="hover" data-placement="left" data-content="You can updated status order here">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div> --}}
                                                                    {{-- <div class="row-fluid">
                                                                    <div class="span5">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                            data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                            <i class="far fa-eye"></i>
                                                                    </button>
                                                                    </div>
                                                                </div> --}}
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'process')
                                                                <div class="row-fluid">
                                                                    <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $encrypts )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    {{-- <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div> --}}
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                                         data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left"
                                                                          data-content="Maaf anda tidak punya akses mengubah statusnya">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                {{-- <div class="row-fluid">
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                                    data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                                    <i class="far fa-eye"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div> --}}
                                                                        </div>
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'invoice')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $encrypts )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    {{-- <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div> --}}
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" data-original-title="Pemberitahuan sistem"
                                                                                 data-trigger="hover" data-placement="left" data-content="Maaf anda tidak punya akses mengubah statusnya">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                    {{-- <div class="row-fluid">
                                                                    <div class="span5">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                            data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                            <i class="far fa-eye"></i>
                                                                    </button>
                                                                    </div>
                                                                </div> --}}
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'done')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $encrypts )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    {{-- <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div> --}}
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" data-original-title="Pemberitahuan sistem"
                                                                                 data-trigger="hover" data-placement="left" data-content="Maaf anda tidak punya akses mengubah statusnya">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                    {{-- <div class="row-fluid">
                                                                    <div class="span5">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                            data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                            <i class="far fa-eye"></i>
                                                                    </button>
                                                                    </div>
                                                                </div> --}}
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'cancel')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $encrypts )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    {{-- <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div> --}}
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" data-original-title="Pemberitahuan sistem"
                                                                                 data-trigger="hover" data-placement="left" data-content="Maaf anda tidak punya akses mengubah statusnya">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                    {{-- <div class="row-fluid">
                                                                    <div class="span5">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                            data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                            <i class="far fa-eye"></i>
                                                                    </button>
                                                                    </div>
                                                                </div> --}}
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'pod')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $encrypts )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    {{-- <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div> --}}
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                                                data-original-title="Pemberitahuan sistem"
                                                                                data-trigger="hover" data-placement="left" data-content="Maaf anda tidak punya akses mengubah statusnya">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                    {{-- <div class="row-fluid">
                                                                    <div class="span5">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                            data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                            <i class="far fa-eye"></i>
                                                                    </button>
                                                                    </div>
                                                                </div> --}}
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'paid')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $encrypts )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    {{-- <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div> --}}
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button readOnly="true" class="btn popovers btn-small btn-info ModalStatusClass" data-toggle="modal" 
                                                                            data-original-title="Pemberitahuan sistem" data-trigger="hover" data-placement="left" 
                                                                            data-content="Maaf anda tidak punya akses mengubah statusnya">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                    {{-- <div class="row-fluid">
                                                                        <div class="span5">
                                                                            <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                                data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                                data-trigger="hover" data-placement="bottom" data-content="Historys Order Status">
                                                                                <i class="far fa-eye"></i>
                                                                        </button>
                                                                        </div>
                                                                    </div> --}}
                                                                    @else
                                                                @endif
                                                                @if ($list_customer->warehouse_o_status->status_name == 'upload')
                                                                <div class="span3">
                                                                        <button onclick="location.href='{{ route('warehouse.show.detail', array( $some, $encrypts )) }}'"
                                                                        data-original-title="Show Detail data {{ $list_customer->order_id }}"
                                                                        data-placement="top" data-trigger="hover" class="btn popovers btn-small btn-primary"
                                                                        data-content="Show detail order" type="button"><i class="icon-file"></i></button>
                                                                    </div>
                                                                    @if($api_v2 == "true")
                                                                    {{-- <div class="span4">
                                                                        <button onclick="location.href='{{ route('exports.perfiles.whs.list',array( $some, $list_customer->id )) }}'"   
                                                                        data-original-title="Export xml file" data-placement="top" data-trigger="hover"
                                                                        class="btn popovers btn-small btn-success" data-content="Save this order to list export"
                                                                        type="button"><i class="icon-large icon-cloud-download"></i></button>
                                                                    </div> --}}
                                                                    @else
                                                                        <div class="span4">
                                                                            <div class="span4">
                                                                                <button data-original-title="System Alert" data-placement="top" data-trigger="hover"
                                                                                class="btn popovers btn-small btn-warning" data-content="Sorry, feature Import disable"
                                                                                type="button"><i class="fas fa-exclamation-circle"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <center><span class='label'>Disabled</span></center> --}}
                                                                    @endif
                                                                    <div class="span3">
                                                                        <button class="btn popovers btn-small btn-info ModalStatusClass" data-id="{{ $list_customer->id }}" 
                                                                                data-target="#ModalStatusOrder" data-toggle="modal" data-original-title="Status Order"
                                                                                data-trigger="hover" data-placement="left" data-content="You can updated status order here">
                                                                            <i class="icon-pencil"></i>
                                                                        </button>
                                                                    </div>
                                                                    {{-- <div class="row-fluid">
                                                                    <div class="span5">
                                                                        <button class="btn popovers btn-small btn-warning ModalShowDataHistoryOrder" data-id="{{ $list_customer->order_id }}" 
                                                                            data-target="#ModalDataOrderTrack" data-toggle="modal" data-original-title="Detail Order Warehouse"
                                                                            data-trigger="hover" data-placement="bottom" data-content="History Order Status">
                                                                            <i class="far fa-eye"></i>
                                                                    </button>
                                                                    </div>
                                                                </div> --}}
                                                                @else
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endfor
                                                </tbody>