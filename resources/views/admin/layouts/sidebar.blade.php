@inject('izin', 'warehouse\Models\Roles')
@php
    $cek_user_branch = Auth::User()->company_branch_id;
    $cek_role_branch = isset($choosen_user_with_branch) ? $choosen_user_with_branch : "undefined";
    foreach ($roles as $key => $jalur) {
        # code...
        $access[] = $jalur->name; 
    }
    $ap = array();
            // ini untuk memberikan semua roles tanpa ada batasan akses    
        foreach (Spatie\Permission\Models\Role::all() as $value => $data) {
            $ap[$value] = $data;
    }
@endphp
{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous"> --}}
{{-- for awesome inco https://fontawesome.com/icons --}}
{{-- <script type="text/javascript" src="{{ asset('js/jquery.pulsate.min.js') }}"></script>  --}}
{{-- <link href="{{ asset('css/pulsing.css') }}" rel="stylesheet" /> --}}
{{-- {{ dd(Auth::User()->roles[1]) }} --}}
@if($cek_role_branch == "undefined")
    {{-- ini adalah non-fitur, non-fitur ini adalah by default dari sistem aplikasi. artinya tidak menampilkan fitur apapun. untuk masalah injection ke API manapun sudah di fix aksesnya. --}}
    @hasrole('super_users','web')
        @if ($cek_super_user_by_owner == 'undefined')
        <ul class="sidebar-menu">
            <li class="sub-menu">
                <a class="" href="{{ route('dashboard') }}">
                    {{-- <i class="icon-dashboard"></i> --}}
                    @if(in_array($cek_role_branch, [42,43,46,50,51,54]))
                        <span class="badge badge-default btn-danger">PT. Tiga Permata Logistik</span>
                    @endif
                    @if(in_array($cek_role_branch, [41,44,45,49,52,53]))
                            <span class="badge badge-default btn-success">PT. Tiga Permata Ekspres</span>
                    @endif
                    @if($cek_role_branch == "undefined")
                            <span class="badge badge-default btn-info">C/B Not Found</span>
                    @endif
                </a>
            </li>
            @if(count((array)$apis) < 2)
            <li class="sub-menu {{ ($menu==='Setting Up Role') ? 'active' : '' || ($menu==='Create User Role') ? 'active' : '' || ($menu==='Company List') ? 'active' : ''}}" >
                <a href="javascript:;" class="">
                    <i class="fas fa-network-wired"></i>
                    <span>Super User</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">
                    <li>
                        <a class="{{ $menu===('Setting Up Role') ? 'active' : '' }}" href="{{ url('super-user-setting-up') }}">
                                <i class="fab fa-critical-role"></i> Setting Roles
                            </a>
                        </li>
                    </ul>
                </li>
                @else
            
            @endif
            </ul>
            @else
            {{-- do something else user is available --}}
        @endif
    @endhasrole
@else
{{-- INI ADALAH SCOPE CHILD DARI PARENTNYA MASING - MASING PARENT ! --}}
{{-- $cek_super_user_by_owner INI ADALAH VARIAN UNTUK MENGECEK APAKAH "undefined" ATAU TIDAK --}}
{{-- JIKA "undefined" MAKA SISTEM MENDETEKSI BAHWA ITU ADALAH CHILDNYA, BEGITU PULA SEBALIKNYA --}}
{{-- ini adalah pembukaan fitur setelah user selesai memilih cabang berdasarkan perusahaannya --}}
@role($access)
<ul class="sidebar-menu">
    <li class="sub-menu">
        <a class="" href="{{ route('role_branch_allowed.open', $cek_role_branch) }}">
            {{-- <i class="icon-dashboard"></i> --}}
        @if(in_array($cek_role_branch, [42,43,46,50,51,54]))
            <span class="badge badge-default btn-danger">PT. Tiga Permata Logistik</span>
        @endif
        @if(in_array($cek_role_branch, [41,44,45,49,52,53]))
                <span class="badge badge-default btn-success">PT. Tiga Permata Ekspres</span>
        @endif
        @if($cek_role_branch == "undefined")
        <span class="badge badge-default btn-info">C/B Not Found</span>
        @endif
        </a>
    </li>
@hasanyrole($ap)
    <li class="sub-menu {{ ($menu==='Warehouse Order List')|| 
        ($menu==='Warehouse Order') ? 'active' : '' || ($menu==='Jobs List Transport') ? 'active' : ''|| ($menu==='Warehouse Order Viewed') ? 'active' : '' || ($menu==='Transport Order') ? 'active' : ''
         ||  ($menu==='Transport Order List') ? 'active' : '' || ($menu==='Viewed Data Transport') ? 'active' : ''}}" >
        <a href="javascript:;" class="">
            <i class="fab fa-jedi-order"></i>
            <span>Transaction</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub">
            @hasanyrole($ap)
            @if ($cek_super_user_by_owner == 'undefined')
            @hasanyrole($ap)
                <li>
                    <a class="{{ $menu===('Warehouse Order List') ? 'active' : '' }}" href="{{ route('warehouse.static', $cek_role_branch) }}">
                        <i class="fas fa-warehouse"></i> Warehouse
                    </a>
                </li>
                <li>
                    <a class="{{ $menu===('Transport Order List') ? 'active' : '' }}" href="{{ route('transport.static', $cek_role_branch) }}">
                        <i class="fas fa-shipping-fast"></i> Transport
                    </a>
                </li>
            @endhasanyrole
                @hasrole('administrator')
                <li>
                    <a class="{{ $menu===('Warehouse Order List') ? 'active' : '' }}" href="{{ route('warehouse.static',$cek_role_branch) }}">
                        <i class="fas fa-warehouse"></i> Warehouse
                    </a>
                </li>
                <li>
                    <a class="{{ $menu===('Transport Order List') ? 'active' : '' }}" href="{{ route('transport.static', $cek_role_branch) }}">
                        <i class="fas fa-shipping-fast"></i> Transport
                    </a>
                </li>
                @endhasrole
                @hasrole('PT. Tiga Permata Logistik - Surabaya WAREHOUSE')
                <li>
                    <a class="{{ $menu===('Warehouse Order List') ? 'active' : '' }}" href="{{ route('warehouse.static',$cek_role_branch) }}">
                        <i class="fas fa-warehouse"></i> Warehouse
                    </a>
                </li>
                {{-- ini untuk fitur PT. Tiga Permata Logistik CABANG Surabaya -> hanya di oprasional warehouse saja --}}
                @endhasrole
                @hasrole('PT. Tiga Permata Logistik - BANDUNG TRANSPORT')
                <li>
                    <a class="{{ $menu===('Transport Order List') ? 'active' : '' }}" href="{{ route('transport.static', $cek_role_branch) }}">
                        <i class="fas fa-shipping-fast"></i> Transport
                    </a>
                </li>
                {{-- ini untuk fitur PT. Tiga Permata Logistik CABANG Surabaya -> hanya di oprasional transport saja --}}
                @endhasrole
                @else 
                <li>
                    {{-- <a class="{{ $menu===('Warehouse Order List') ? 'active' : '' }}" href="{{ route('warehouse.static', Auth::User()->company_branch_id) }}"> --}}
                    <a class="{{ $menu===('Warehouse Order List') ? 'active' : '' }}" href="{{ route('warehouse.static', $cek_role_branch) }}">
                        <i class="fas fa-warehouse"></i> Warehouses
                    </a>
                </li>
                <li>
                    <a class="{{ $menu===('Transport Order List') ? 'active' : '' }}" href="{{ route('transport.static', $cek_role_branch) }}">
                        <i class="fas fa-shipping-fast"></i> Transport
                    </a>
                </li>
            @endif
            @endhasanyrole
            </li>
        </ul>
    </li>
    @endhasanyrole
    @role('administrator|super_users')
    <li class="sub-menu {{
    ($menu==='Details Shipment Job List') ? 'active' : ''|| ($menu==='Google Drive File List') ? 'active' : '' || ($menu==='Histroy Jobs shipment') ? 'active' : ''}}">
    <a href="javascript:;" class="">
        <i class="fas fa-paste"></i>
        <span>Jobs</span>
        <span class="arrow"></span>
    </a>
    <ul class="sub">
    @role('PT. Tiga Permata Logistik - BANDUNG TRANSPORT|super_users|administrator|PT. Tiga Permata Logistik Surabaya ALL PERMISSION')
        @if ($cek_super_user_by_owner == 'undefined')
        {{-- scope user child of parent --}}
            @hasrole('PT. Tiga Permata Logistik Surabaya ALL PERMISSION')
                <li>
                    <a class="{{ $menu===('Details Shipment Job List') ? 'active' : '' }}" href="{{ route('joblist.show',  $cek_role_branch) }}">
                        <i class="fas fa-file-contract"></i>Job shipment
                    </a>
                </li>
                <li>
                    <a class="{{ $menu===('Histroy Jobs shipment') ? 'active' : '' }}" href="{{ route('history.job.transaction', $cek_role_branch) }}"> {{-- in progress history shipment --}}
                        <i class="fas fa-file-contract"></i>Histories
                    </a>
                </li>
            @endhasrole
            @hasrole('PT. Tiga Permata Logistik - BANDUNG TRANSPORT')
            <li>
                <a class="{{ $menu===('Details Shipment Job List') ? 'active' : '' }}" href="{{ route('joblist.show',  $cek_role_branch) }}">
                    <i class="fas fa-file-contract"></i>Job shipment
                </a>
            </li>
            <li>
                <a class="{{ $menu===('Histroy Jobs shipment') ? 'active' : '' }}" href="{{ route('history.job.transaction', $cek_role_branch) }}"> {{-- in progress history shipment --}}
                    <i class="fas fa-file-contract"></i>Histories
                </a>
            </li>
        @endhasrole
        @else
        <li>
            <a class="{{ $menu===('Details Shipment Job List') ? 'active' : '' }}" href="{{ route('joblist.show',  $cek_role_branch) }}">
                <i class="fas fa-file-contract"></i>Job shipment
            </a>
        </li>
        <li>
            <a class="{{ $menu===('Histroy Jobs shipment') ? 'active' : '' }}" href="{{ route('history.job.transaction', $cek_role_branch) }}"> {{-- in progress history shipment --}}
                <i class="fas fa-file-contract"></i>Histories
            </a>
        </li>
        @endif
    @endrole
        @hasrole('administrator')
            <li>
                <a class="{{ $menu===('Details Shipment Job List') ? 'active' : '' }}" href="{{ route('joblist.show',  $cek_role_branch) }}">
                    <i class="fas fa-file-contract"></i>Job shipment
                </a>
            </li>
            <li>
                <a class="{{ $menu===('Histroy Jobs shipment') ? 'active' : '' }}" href="{{ route('history.job.transaction', $cek_role_branch) }}"> {{-- in progress history shipment --}}
                    <i class="fas fa-file-contract"></i>History
                </a>
            </li>
        @endhasrole
        </ul>
    </li>
@endrole()
@role('administrator')
    <li class="sub-menu {{ ($menu==='Warehouse Order List')|| 
        ($menu==='Cash Advanced list') ? 'active' : '' || ($menu==='asdacxzdsa') ? 'active' : ''
         ||  ($menu==='Detail Cash Advanced List') ? 'active' : '' || ($menu==='asdasd') ? 'active' : ''}}" >
        <a href="javascript:;" class="">
            <i class="fas fa-file-invoice-dollar"></i>
            <span>Cash Advanced</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub">
            @role('PT. Tiga Permata Logistik[SPV]|PT. Tiga Permata Ekspres[SPV]|PT. Tiga Permata Logistik[DRIVERS]|PT. Tiga Permata Ekspres[DRIVERS]|PT. Tiga Permata Logistik[OPRASONAL][KASIR]|PT. Tiga Permata Ekspres[OPRASONAL][KASIR]|administrator|super_users|PT. Tiga Permata Logistik Surabaya ALL PERMISSION')
            @if ($cek_super_user_by_owner == 'undefined')
                @hasrole('PT. Tiga Permata Logistik Surabaya ALL PERMISSION')
                    <li>
                        <a class="{{ $menu===('Cash Advanced list') ? 'active' : '' }}" href="{{ route('cashadvanced.list', $cek_role_branch)}}">
                            <i class="fas fa-money-check"></i> Credits
                        </a>
                    </li>
                @endhasrole
            @else
                <li>
                    <a class="{{ $menu===('Cash Advanced list') ? 'active' : '' }}" href="{{ route('cashadvanced.list', $cek_role_branch)}}">
                        <i class="fas fa-money-check"></i> Credits
                    </a>
                </li>
            @endif
            @endrole
            @hasrole('administrator')
                <li>
                    <a class="{{ $menu===('Cash Advanced list') ? 'active' : '' }}" href="{{ route('cashadvanced.list', $cek_role_branch)}}">
                        <i class="fas fa-money-check"></i> Credits
                    </a>
                </li>
            @endhasrole
            </li>
        </ul>
    </li>
@endrole
@role('administrator')
<li class="sub-menu {{ ($menu==='Accurate List')|| 
    ($menu==='Export List') ? 'active' : ''}}" >
    <a href="javascript:;" class="">
        <i class="icon-desktop"></i>
        <span>Accounting</span>
        <span class="arrow"></span>
    </a>
        <ul class="sub">
        @role('PT. Tiga Permata Logistik[ACCOUNTING][TC]|PT. Tiga Permata Logistik[ACCOUNTING][WHS][TC]|PT. Tiga Permata Logistik[ACCOUNTING][WHS]|administrator|super_users|PT. Tiga Permata Logistik Surabaya ALL PERMISSION')
        @if ($cek_super_user_by_owner == 'undefined')
            @hasrole('PT. Tiga Permata Logistik Surabaya ALL PERMISSION')
                <li>
                    <a class="{{ $menu===('Export List') ? 'active' : '' }}" href="{{ route('exports.static', $cek_role_branch) }}">
                        <i class="fas fa-cloud-upload-alt"></i> Accurate Exports
                    </a>
                </li>
                <li>
                    <a class="{{ $menu===('Warehouse order status') ? 'active' : '' }}" href="{{ route('accwhs.static', $cek_role_branch) }}">
                        <i class="fas fa-file-invoice"></i> Warehouse Order
                    </a>
                </li>
                <li>
                    <a class="{{ $menu===('Transport order status') ? 'active' : '' }}" href="{{ route('acctc.static', $cek_role_branch) }}">
                        <i class="fas fa-file-invoice"></i> Transport Order
                    </a>
                </li>
            @endhasrole
        @else
            <li>
                <a class="{{ $menu===('Export List') ? 'active' : '' }}" href="{{ route('exports.static', $cek_role_branch) }}">
                    <i class="fas fa-cloud-upload-alt"></i> Accurate Exports
                </a>
            </li>
        @endif
        @endrole
            @role('PT. Tiga Permata Logistik[ACCOUNTING][WHS][TC]|PT. Tiga Permata Logistik[ACCOUNTING][WHS]|administrator|super_users')
            @if ($cek_super_user_by_owner == 'undefined')
               
            @else
            <li>
                <a class="{{ $menu===('Warehouse order status') ? 'active' : '' }}" href="{{ route('accwhs.static', $cek_role_branch) }}">
                    <i class="fas fa-file-invoice"></i> Warehouse Order
                </a>
            </li>
            @endif
            @endrole
            @role('PT. Tiga Permata Logistik[ACCOUNTING][WHS][TC]|PT. Tiga Permata Logistik[ACCOUNTING][TC]|administrator|super_users')
            @if ($cek_super_user_by_owner == 'undefined')
               
            @else
                <li>
                    <a class="{{ $menu===('Transport order status') ? 'active' : '' }}" href="{{ route('acctc.static', $cek_role_branch) }}">
                        <i class="fas fa-file-invoice"></i> Transport Order
                    </a>
                </li>
            @endif
            @endrole
            @hasrole('administrator')
            <li>
                <a class="{{ $menu===('Export List') ? 'active' : '' }}" href="{{ route('exports.static', $cek_role_branch) }}">
                    <i class="fas fa-cloud-upload-alt"></i> Accurate Exports
                </a>
            </li>
            <li>
                <a class="{{ $menu===('Warehouse order status') ? 'active' : '' }}" href="{{ route('accwhs.static', $cek_role_branch) }}">
                    <i class="fas fa-file-invoice"></i> Warehouse Order
                </a>
            </li>
            <li>
                <a class="{{ $menu===('Transport order status') ? 'active' : '' }}" href="{{ route('acctc.static', $cek_role_branch) }}">
                    <i class="fas fa-file-invoice"></i> Transport Order
                </a>
            </li>
            @endhasrole
        </ul>
    </li>
@endrole
@role('PT. Tiga Permata Logistik[OPRASONAL][WHS]|PT. Tiga Permata Logistik[OPRASONAL][TC][WHS]|administrator|super_users|PT. Tiga Permata Logistik - Surabaya WAREHOUSE|PT. Tiga Permata Logistik Surabaya ALL PERMISSION')
<li class="sub-menu {{ ($menu==='Item Warehouse Detail') ? 'active' : '' ||
($menu==='Warehouse Item List') ? 'active' : ''}}">
<a href="javascript:;" class="">
    <i class="fas fa-paste"></i>
    <span>Data Warehouse</span>
    <span class="arrow"></span>
</a>
<ul class="sub">
        @if ($cek_super_user_by_owner == 'undefined')
        @hasrole('administrator')
        <li>
            <a class="{{ $menu===('Warehouse Item List') ? 'active' : '' }}" href="{{ route('itemslist.show', $cek_role_branch) }}">
                <i class="fas fa-cubes"></i> Item Service WH
            </a>
        </li>
        @endhasrole 
        @hasrole('PT. Tiga Permata Logistik - Surabaya WAREHOUSE|PT. Tiga Permata Logistik Surabaya ALL PERMISSION')
        <li>
            <a class="{{ $menu===('Warehouse Item List') ? 'active' : '' }}" href="{{ route('itemslist.show', $cek_role_branch) }}">
                <i class="fas fa-cubes"></i> Item Service WH
            </a>
        </li>
        @endhasrole 
        @else
    <li>
        <a class="{{ $menu===('Warehouse Item List') ? 'active' : '' }}" href="{{ route('itemslist.show', $cek_role_branch) }}">
            <i class="fas fa-cubes"></i> Item Service WH
        </a>
    </li>
@endif
</ul>
</li>
@endrole()

@hasanyrole($ap)
<li class="sub-menu {{ ($menu==='Customer Transport List') || ($menu==='Item Warehouse Detail') ? 'active' : '' ||
($menu==='Vendor Transport List') ? 'active' : ''}}">
<a href="javascript:;" class="">
    <i class="fas fa-paste"></i>
    <span>Data Transport</span>
    <span class="arrow"></span>
</a>
<ul class="sub">
        @if ($cek_super_user_by_owner == 'undefined')
            @hasrole('administrator')
            <li>
                <a class="{{ $menu===('Customer Transport List') ? 'active' : '' }}" href="{{ route('datacustomer.show', $cek_role_branch) }}">
                    <i class="fas fa-user-tie"></i> Item Customer
                </a>
            </li>
            <li>
                <a class="{{ $menu===('Vendor Transport List') ? 'active' : '' }}" href="{{ route('datavendor.show', $cek_role_branch) }}">
                    <i class="fas fa-user-friends"></i> Item Vendor
                </a>
            </li>
            @endhasrole
            @hasanyrole($ap)
            <li>
                <a class="{{ $menu===('Customer Transport List') ? 'active' : '' }}" href="{{ route('datacustomer.show', $cek_role_branch) }}">
                    <i class="fas fa-user-tie"></i> Item Customer
                </a>
            </li>
            <li>
                <a class="{{ $menu===('Vendor Transport List') ? 'active' : '' }}" href="{{ route('datavendor.show', $cek_role_branch) }}">
                    <i class="fas fa-user-friends"></i> Item Vendor
                </a>
            </li>
            @endhasanyrole
        @else
    <li>
        <a class="{{ $menu===('Customer Transport List') ? 'active' : '' }}" href="{{ route('datacustomer.show', $cek_role_branch) }}">
            <i class="fas fa-user-tie"></i> Item Customer
        </a>
    </li>
    <li>
        <a class="{{ $menu===('Vendor Transport List') ? 'active' : '' }}" href="{{ route('datavendor.show', $cek_role_branch) }}">
            <i class="fas fa-user-friends"></i> Item Vendor
        </a>
    </li>
    @endif
</ul>
</li>
@endhasanyrole
@hasanyrole($ap)
    <li class="sub-menu {{ ($menu==='Customer List')|| ($menu==='Modas List') || ($menu==='Sub Service Details') ? 'active' : '' || ($menu==='Master Item Accurate Cloud') ? 'active' : '' ||
    ($menu==='Customer Registration') ? 'active' : '' || ($menu==='Vendor List') ? 'active' : '' 
    || ($menu==='Item Registration') || ($menu==='Vendor Registration') ? 'active' : '' || ($menu==='Address Book List') ? 'active' : '' ||
     ($menu==='Address Book Registration') ? 'active' : '' || ($menu==='Shipment Category List') ? 'active' : ''  || ($menu==='Shipment Category List') ? 'active' : '' || ($menu==='Address Book List') ? 'active' : '' ||
     ($menu==='Sub Service List') ? 'active' : ''|| ($menu==='Edit Vehicle List') ? 'active' : '' || ($menu==='Vehicle List') ? 'active' : '' || ($menu==='Sales Order List') ? 'active' : ''}}">
    <a href="javascript:;" class="">
        <i class="icon-dropbox"></i>
        <span>Data Master</span>
        <span class="arrow"></span>
    </a>
    <ul class="sub">
            @if ($cek_super_user_by_owner == 'undefined')
                @hasrole('administrator')
                <li>
                    <a class="{{ $menu===('Master Item Accurate Cloud') ? 'active' : '' }}" href="{{ route('masterItemAccurate.index', $cek_role_branch) }}">
                        <i class="fas fa-truck"></i> Item Accurate
                    </a>
                </li>
                <li>
                    <a class="{{ $menu===('Vehicle List') ? 'active' : '' }}" href="{{ route('list.master.vehicle', $cek_role_branch) }}">
                        <i class="fas fa-truck"></i> Vehicle
                    </a>
                </li>
                <li>
                    <a class="{{ $menu===('Address Book List') ? 'active' : '' }}" href="{{ route('master.address.book', $cek_role_branch) }} ">
                        <i class="fas fa-address-book"></i> Address Book
                    </a>
                    </li>
                <li>
                    <a class="{{ $menu===('Customer List') ? 'active' : '' }}" href="{{ route('master.customer.list', $cek_role_branch) }}">
                        <i class="fas fa-user-tie"></i> Customer
                    </a>
                </li>
                <li>
                    <a class="{{ $menu===('Vendor List') ? 'active' : '' }}" href="{{ route('master.vendor.list', $cek_role_branch) }}">
                        <i class="fas fa-user-circle"></i> Vendor
                    </a>
                </li>
                <li>
                    <a class="{{ $menu===('Sub Service List') ? 'active' : '' }}" href="{{ route('master.sub_services.list', $cek_role_branch) }}">
                        <i class="fas fa-tint"></i> Sub services
                    </a>
                </li>
                <li>
                    <a class="{{ $menu===('Shipment Category List') ? 'active' : '' }}" href="{{ route('master.shipment.category.list', $cek_role_branch) }}">
                        <i class="fas fa-clipboard-list"></i> Ship Category
                    </a>
                </li>
                <li>
                    <a class="{{ $menu===('Moda List') ? 'active' : '' }}" href="{{ route('master.data.modas', $cek_role_branch) }}">
                        <i class="fas fa-luggage-cart"></i> Moda
                    </a>
                </li>
                {{-- <li>
                    <a class="{{ $menu===('Sales Order List') ? 'active' : '' }}" href="{{ route('master.sales.order', $cek_role_branch) }}">
                        <i class="fas fa-user-plus"></i> Sales Order
                    </a>
                </li> --}}
                @endhasrole
                @hasanyrole($ap)
                    <li>
                        <a class="{{ $menu===('Vehicle List') ? 'active' : '' }}" href="{{ route('list.master.vehicle', $cek_role_branch) }}">
                            <i class="fas fa-truck"></i> Vehicle
                        </a>
                    </li>
                    <li>
                        <a class="{{ $menu===('Address Book List') ? 'active' : '' }}" href="{{ route('master.address.book', $cek_role_branch) }} ">
                            <i class="fas fa-address-book"></i> Address Book
                        </a>
                        </li>
                    <li>
                        <a class="{{ $menu===('Customer List') ? 'active' : '' }}" href="{{ route('master.customer.list', $cek_role_branch) }}">
                            <i class="fas fa-user-tie"></i> Customer
                        </a>
                    </li>
                    <li>
                        <a class="{{ $menu===('Vendor List') ? 'active' : '' }}" href="{{ route('master.vendor.list', $cek_role_branch) }}">
                            <i class="fas fa-user-circle"></i> Vendor
                        </a>
                    </li>
                    <li>
                        <a class="{{ $menu===('Sub Service List') ? 'active' : '' }}" href="{{ route('master.sub_services.list', $cek_role_branch) }}">
                            <i class="fas fa-tint"></i> Sub services
                        </a>
                    </li>
                    <li>
                        <a class="{{ $menu===('Shipment Category List') ? 'active' : '' }}" href="{{ route('master.shipment.category.list', $cek_role_branch) }}">
                            <i class="fas fa-clipboard-list"></i> Ship Category
                        </a>
                    </li>
                    <li>
                        <a class="{{ $menu===('Moda List') ? 'active' : '' }}" href="{{ route('master.data.modas', $cek_role_branch) }}">
                            <i class="fas fa-luggage-cart"></i> Moda
                        </a>
                    </li>
                    <li>
                        <a class="{{ $menu===('Sales Order List') ? 'active' : '' }}" href="{{ route('master.sales.order', $cek_role_branch) }}">
                            <i class="fas fa-user-plus"></i> Sales Order
                        </a>
                    </li>
                @endhasanyrole
            @else
        <li>
            <a class="{{ $menu===('Master Item Accurate Cloud') ? 'active' : '' }}" href="{{ route('masterItemAccurate.index', $cek_role_branch) }}">
                <i class="fas fa-truck"></i> Item Accurate
            </a>
        </li>
            <li>
                <a class="{{ $menu===('Vehicle List') ? 'active' : '' }}" href="{{ route('list.master.vehicle', $cek_role_branch) }}">
                    <i class="fas fa-truck"></i> Vehicle
                </a>
            </li>
        <li>
            <a class="{{ $menu===('Address Book List') ? 'active' : '' }}" href="{{ route('master.address.book', $cek_role_branch) }} ">
                <i class="fas fa-address-book"></i> Address Book
            </a>
            </li>
        <li>
            <a class="{{ $menu===('Customer List') ? 'active' : '' }}" href="{{ route('master.customer.list', $cek_role_branch) }}">
                <i class="fas fa-user-tie"></i> Customer
            </a>
        </li>
        <li>
            <a class="{{ $menu===('Vendor List') ? 'active' : '' }}" href="{{ route('master.vendor.list', $cek_role_branch) }}">
                <i class="fas fa-user-circle"></i> Vendor
            </a>
        </li>
        <li>
            <a class="{{ $menu===('Sub Service List') ? 'active' : '' }}" href="{{ route('master.sub_services.list', $cek_role_branch) }}">
                <i class="fas fa-tint"></i> Sub services
            </a>
        </li>
        <li>
            <a class="{{ $menu===('Shipment Category List') ? 'active' : '' }}" href="{{ route('master.shipment.category.list', $cek_role_branch) }}">
                <i class="fas fa-clipboard-list"></i> Ship Category
            </a>
        </li>
        <li>
            <a class="{{ $menu===('Moda List') ? 'active' : '' }}" href="{{ route('master.data.modas', $cek_role_branch) }}">
                <i class="fas fa-luggage-cart"></i> Moda
            </a>
        </li>
        <li>
            <a class="{{ $menu===('Sales Order List') ? 'active' : '' }}" href="{{ route('master.sales.order', $cek_role_branch) }}">
                <i class="fas fa-user-plus"></i> Sales Order
            </a>
        </li>
        @endif
    </ul>
</li>
@endhasanyrole
@role('administrator|super_users', 'web')
<li class="sub-menu {{ ($menu==='User Management')|| 
    ($menu==='Users List') ? 'active' : '' || ($menu==='Set up User') ? 'active' : '' || ($menu==='Permissions List') ? 'active' : '' || 
    ($menu==='Create Add Permission') ? 'active' : '' || ($menu==='Roles List') ? 'active' : '' ||
    ($menu==='Create Add Roles') ? 'active' : '' || ($menu==='Create User List') ? 'active' : '' }}" >
    <a href="javascript:;" class="">
        <i class="fas fa-network-wired"></i>
        <span>User Management</span>
        <span class="arrow"></span>
    </a>
    <ul class="sub">
        @role('administrator')
        <li>
            <a class="{{ $menu===('Permission List') ? 'active' : '' }}" href="{{ route('permissions.list.index', $cek_role_branch)  }}">
                <i class="fab fa-hubspot"></i> Permission
            </a>
        </li>
        <li>
            <a class="{{ $menu===('Roles List') ? 'active' : '' }}" href="{{ route('roles.list.index', $cek_role_branch) }}">
                <i class="fab fa-critical-role"></i> Roles
            </a>
        </li>
        @endrole
        @role('super_users|administrator')
        <li>
            <a class="{{ $menu===('Create User List') ? 'active' : '' }}" href="{{ route('users.list.index', $cek_role_branch) }}">
                <i class="fas fa-users-cog"></i> Users
            </a>
        </li>
        @endrole
    </ul>
</li>
    @else
        {{-- @role('super_users', 'web') --}}
        @role('administrator', 'web')
            <li class="sub-menu {{ ($menu==='Setting Up Role') ? 'active' : '' || ($menu==='Create User Role') ? 'active' : '' || ($menu==='Company List') ? 'active' : ''}}" >
                <a href="javascript:;" class="">
                    <i class="fas fa-network-wired"></i>
                    <span>Super User</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub">
                    @if ($cek_super_user_by_owner == 'undefined')
                    <li>
                        <a class="{{ $menu===('Setting Up Role') ? 'active' : '' }}" href="{{ url('super-user-setting-up') }}">
                            <i class="fab fa-critical-role"></i> Setting Roles
                        </a>
                    </li>
                        @else
                            <li>
                                <a class="{{ $menu===('Create User Role') ? 'active' : '' }}" href="{{ route('users.list.index', $cek_role_branch) }}">
                                    <i class="fas fa-user-plus"></i> Create User
                                </a>
                            </li>
                            <li>
                                <a class="{{ $menu===('Company List') ? 'active' : '' }}" href="{{ url('Companys') }}"> {{-- this tb compny--}}
                                    <i class="fas fa-city"></i> Company
                                </a>
                            </li>
                            <li>
                                <a class="{{ $menu===('Branch List') ? 'active' : '' }}" href="{{ url('Branchs') }}"> {{-- this tb branch--}}
                                    <i class="fas fa-building"></i> Branch
                                </a>
                            </li>
                    @endif
                </ul>
            </li>
        @endrole
@endrole
@role('administrator')
    <li class="sub-menu {{ $menu===('APIs Client') ? 'active' : '' }}" >
        <a href="javascript:;" class="">
            <i class="fab fa-jedi-order"></i>
            <span>Integration</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub">
             @role('administrator|super_users|PT. Tiga Permata Logistik Surabaya ALL PERMISSION|PT. Tiga Permata Ekspres Surabaya ALL PERMISSION')
                @if ($cek_super_user_by_owner == 'undefined')
                    @role('administrator')
                    <li>
                        <a class="{{ $menu===('APIs Client') ? 'active' : '' }}" href="{{ route('api.ui', $cek_role_branch) }}">
                            <i class="fas fa-file-invoice"></i> Developer
                        </a>
                    </li>
                    @endrole
                    @role('PT. Tiga Permata Logistik - BANDUNG TRANSPORT')
                    <li>
                        <a class="{{ $menu===('APIs Client') ? 'active' : '' }}" href="{{ route('api.ui', $cek_role_branch) }}">
                            <i class="fas fa-file-invoice"></i> Child users
                        </a>
                    </li>
                    @endrole
                    @role('PT. Tiga Permata Logistik - Surabaya WAREHOUSE')
                    <li>
                        <a class="{{ $menu===('APIs Client') ? 'active' : '' }}" href="{{ route('api.ui', $cek_role_branch) }}">
                            <i class="fas fa-file-invoice"></i> Activated APIs
                        </a>
                    </li>
                    @endrole
                @else
                    <li>
                        <a class="{{ $menu===('APIs Client') ? 'active' : '' }}" href="{{ route('api.ui', $cek_role_branch) }}">
                            <i class="fas fa-file-invoice"></i> Super users
                        </a>
                    </li>
                    <li>
                        @if(session('AccountAccurate'))
                                <a class="{{ $menu===('APIs Client') ? 'active' : '' }}" href="#AccountIsActivated">
                            @else
                            <a class="{{ $menu===('APIs Client') ? 'active' : '' }}" href="{{ route('api.accurate.cloud.id', $cek_role_branch) }}">
                                @endif
                                <i class="fas fa-file-invoice"></i> Accurate Cloud
                            </a>
                        </li>
                    @endif
                @endrole
            @can('developer')
                @role('PT. Tiga Permata Logistik[ACCOUNTING][TC]|PT. Tiga Permata Logistik[OPRASONAL][WHS]')
                <li>
                    <a class="{{ $menu===('APIs Client') ? 'active' : '' }}" href="{{ route('api.ui', $cek_role_branch) }}">
                        <i class="fas fa-file-invoice"></i> Accurate Desktop
                    </a>
                </li>
                @endrole
            @endcan()
        </ul>
    </li>
@endrole
@role('administrator')
@if($api_v2 == 'true')
    @if(count($alert_items) || count($alert_customers) || count($system_alert_item_customer) || count($system_alert_item_vendor))
      <li class="tooltips sub-menu {{ ($menu==='Alert List')||
      ($menu==='System Alert List') ? 'active' : '' || $menu===('System Item Vendor List') ? 'active' : '' || $menu===('System Item List') ? 'active' : ''
      || $menu===('System Customer List') ? 'active' : '' ||$menu===('System Item Customer Transport List') ? 'active' : '' || $menu===('System Item Customer List') ? 'active' : ''}} }}" >
      <a href="javascript:;" class="">
        <i class="fas fa-code-branch"></i>
          <span>System Alerts &nbsp;<i class="fas fa-exclamation"></i></span>
          <span class="arrow"></span>
      </a>
          <ul class="sub">
            @if(count($alert_items))
                @if ($cek_super_user_by_owner == 'undefined')
                {{-- Do something, if not not super user (this scope child) --}}
                @hasrole('PT. Tiga Permata Logistik Surabaya ALL PERMISSION')
                <li>
                    <a class="{{ $menu===('System Item List') ? 'active' : '' }}" href="{{ route('system.alert.item.whs', $cek_role_branch) }}">
                        <p class="tooltips" style="color: crimson" data-original-title="
                    You have data that has not been exported {{count($alert_items)}}" data-placement="top">
                    <i class="fas fa-cubes"></i>Items <span class="pulse badge badge-warning">{{count($alert_items)}}</span></p> 
                    </a>
                </li>
                @endhasrole
                    @else
                        <li>
                            <a class="{{ $menu===('System Item List') ? 'active' : '' }}" href="{{ route('system.alert.item.whs', $cek_role_branch) }}">
                                <p class="tooltips" style="color: crimson" data-original-title="
                            You have data that has not been exported {{count($alert_items)}}" data-placement="top">
                            <i class="fas fa-cubes"></i>Items <span class="pulse badge badge-warning">{{count($alert_items)}}</span></p> 
                            </a>
                        </li>
                        @endif
                    @else
                @endif
        @if(count($alert_customers))
            @if ($cek_super_user_by_owner == 'undefined')
                {{-- Do something, if not not super user (this scope child) --}}
                @hasanyrole($ap)
                <li>
                    <a class="{{ $menu===('System Customer List') ? 'active' : '' }}" href="{{ route('system.alert.customers', $cek_role_branch) }}">
                        <p class="tooltips" style="color: crimson" data-original-title="
                    You have data that has not been exported {{count($alert_customers)}}" data-placement="top">
                        <i class="icon-group"></i>Customer <span class="pulse badge badge-warning">{{count($alert_customers)}}</span></p> 
                    </a>
                </li>
                @endhasanyrole
                @else
                    <li>
                        <a class="{{ $menu===('System Customer List') ? 'active' : '' }}" href="{{ route('system.alert.customers', $cek_role_branch) }}">
                            <p class="tooltips" style="color: crimson" data-original-title="
                        You have data that has not been exported {{count($alert_customers)}}" data-placement="top">
                            <i class="icon-group"></i>Customer <span class="pulse badge badge-warning">{{count($alert_customers)}}</span></p> 
                        </a>
                    </li>
                @endif
            @else
        @endif
        @if(count($system_alert_item_customer))
        @if ($cek_super_user_by_owner == 'undefined')
            {{-- Do something, if not not super user (this scope child) --}}
            @hasanyrole($ap)
            <li>
                <a class="{{ $menu===('System Item Customer List') ? 'active' : '' }}" href="{{ route('system.alert.customers.transports', $cek_role_branch) }}">
                    <p class="tooltips" style="color: crimson" data-original-title="
                You have data that has not been exported {{count($system_alert_item_customer)}}" data-placement="top">
                <i class="icon-group"></i>Customer <span class="pulse badge badge-warning">{{count($system_alert_item_customer)}}</span></p> 
                </a>
            </li>
            @endhasanyrole
            @else
                <li>
                    <a class="{{ $menu===('System Item Customer Transport List') ? 'active' : '' }}" href="{{ route('system.alert.customers.transports', $cek_role_branch) }}">
                        <p class="tooltips" style="color: crimson" data-original-title="
                    You have data that has not been exported {{count($system_alert_item_customer)}}" data-placement="top">
                    <i class="icon-group"></i>Customer <span class="pulse badge badge-warning">{{count($system_alert_item_customer)}}</span></p> 
                    </a>
                </li>
                @endif
            @else
        @endif
            @if(count($system_alert_item_vendor))
                @if ($cek_super_user_by_owner == 'undefined')
                {{-- Do something, if not not super user (this scope child) --}}
                @hasrole('PT. Tiga Permata Logistik Surabaya ALL PERMISSION')
                <li>
                    <a class="{{ $menu===('System Item Vendor List') ? 'active' : '' }}" href="{{ route('system.alert.vendors.transports', $cek_role_branch) }}">
                        <p class="tooltips" style="color: crimson" data-original-title="
                    You have data that has not been exported {{count($system_alert_item_vendor)}}" data-placement="top">
                    <i class="fas fa-user-friends"></i>Vendor <span class="pulse badge badge-warning">{{count($system_alert_item_vendor)}}</span></p> 
                    </a>
                </li>
                @endhasrole
                    @else
                        <li>
                            <a class="{{ $menu===('System Item Vendor List') ? 'active' : '' }}" href="{{ route('system.alert.vendors.transports', $cek_role_branch) }}">
                                <p class="tooltips" style="color: crimson" data-original-title="
                            You have data that has not been exported {{count($system_alert_item_vendor)}}" data-placement="top">
                            <i class="fas fa-user-friends"></i>Vendor <span class="pulse badge badge-warning">{{count($system_alert_item_vendor)}}</span></p> 
                            </a>
                        </li>
                    @endif
                @else
            @endif
            </li>
            @else
        @endif
    @endif
@endrole
</ul>
@else
<ul class="sidebar-menu">
    <li class="sub-menu">
        <a class="" href="{{ route('dashboard') }}">
            {{-- <i class="icon-dashboard"></i> --}}
            @if(in_array($cek_role_branch, [42,43,46,50,51,54]))
                <span class="badge badge-default btn-danger">PT. Tiga Permata Logistik</span>
            @endif
            @if(in_array($cek_role_branch, [41,44,45,49,52,53]))
                <span class="badge badge-default btn-success">PT. Tiga Permata Ekspres</span>
            @endif
            @if($cek_role_branch == "undefined")
            <span class="badge badge-default btn-info">C/B Not Found</span>
            @endif
        </a>
    </li>
</ul>
@endrole
@endif
