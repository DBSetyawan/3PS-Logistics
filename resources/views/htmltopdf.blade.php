<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoice Customer</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightslategray
    }
</style>

</head>
<body>
  <table width="100%">
    <tr>
        <td valign="top"><img src="{{asset('./img/avatar-mini.png')}}" alt="" width="150"/></td>
        <td align="right">
            <h3>PT. Tiga Permata Logistik</h3>
            <pre>
                3PL
                Jln. Waru KM 15, Sawotratap
                102931
                031-8533130
                021-30294221
            </pre>
        </td>
    </tr>

  </table>

  <table width="100%">
    <tr>
        <td><strong>From:</strong> artexsdns@gmail.com</td>
        <td><strong>To:</strong> Linblum - Barrio Comercial</td>
    </tr>
  </table>
  <br/>
  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th style="width: 13%">#Order ID</th>
        <th style="width: 13%">Customer Name</th>
        <th style="width: 15%">Customer Name PIC</th>
        <th style="width: 13%">Customer PIC Phone</th>
        <th style="width: 11%">Sub Services</th>
        <th style="width: 13%">Contract Number</th>
        <th style="width: 13%">SQ Number</th>
        <th style="width: 13%">SO Number</th>
        <th style="width: 10%">Remark</th>
        <th style="width: 10%">Volume</th>
        <th style="width: 6%">UOM</th>
        <th style="width: 7%">Rate</th>
        <th style="width: 12%">Total Rp.</th>
      </tr>
    </thead>
    <tbody>
        @php($total = 0);
            <tr>
                <td>{{$warehouseTolist->order_id}}</td>
                <td align="right">{{$warehouseTolist->customers_warehouse->director}}</td>
                <td colspan="3" align="right">{{$warehouseTolist->sub_service->name}}</td>
                <td align="right">{{$warehouseTolist->contract_no}}</td>
                <td align="right">{{$warehouseTolist->SQ_no}}</td>
                <td align="right">{{$warehouseTolist->SO_no}}</td>
                <td align="right">{{$warehouseTolist->remark}}</td>
                <td align="right">{{$warehouseTolist->volume}}</td>
                <td align="right">{{$warehouseTolist->wom}}</td>
                <td align="right">{{$warehouseTolist->rate}}</td>
                <td align="right">{{$warehouseTolist->total_rate}}</td>
                @foreach ($warehouse_order_pic as $item)
            <tr>
                <td colspan="3" align="right">{{$item->to_do_list_cspics->name}}</td>
                <td align="right">{{$item->to_do_list_cspics->phone}}</td>
                {{-- <td align="right">{{$item->to_do_list_cspics->name}}</td> --}}
            </tr>
                @endforeach
            </tr>       
               @php($total += $warehouseTolist->total_rate)
            </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="11"></td>
            <td align="right">Subtotal</td>
            <td align="right" class="gray">{{number_format($total,2)}}</td>
        </tr>
    </tfoot>
  </table>
</body>
</html>