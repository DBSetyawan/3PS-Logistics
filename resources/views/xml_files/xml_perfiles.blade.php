<?php print '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<NMEXML EximID="490" BranchCode="238055809" ACCOUNTANTCOPYID="">
  <TRANSACTIONS OnError="CONTINUE">
    <SALESORDER operation="Add" REQUESTID="1">
      <TRANSACTIONID>26620</TRANSACTIONID>
      <ITEMLINE operation="Add">
        <keyID>0</keyID>
        {{-- <ITEMNO>{{$warehouse_order->item_t->itemno}}</ITEMNO> --}}
        {{-- <ITEMNO>@foreach($warehouse_order->sub_service->item as $item){{$item->itemno}}@endforeach</ITEMNO> --}}
        <ITEMNO>{{$warehouse_order->sub_service->item_id_sewa_gudang}}</ITEMNO>
        <QUANTITY>{{$warehouse_order->volume}}</QUANTITY>
        <ITEMUNIT></ITEMUNIT>
        <UNITRATIO></UNITRATIO>
        <ITEMRESERVED1></ITEMRESERVED1>
        <ITEMRESERVED2>{{$warehouse_order->wom}}</ITEMRESERVED2>
        <ITEMRESERVED3></ITEMRESERVED3>
        <ITEMRESERVED4></ITEMRESERVED4>
        <ITEMRESERVED5></ITEMRESERVED5>
        <ITEMRESERVED6></ITEMRESERVED6>
        <ITEMRESERVED7></ITEMRESERVED7>      
        <ITEMRESERVED8></ITEMRESERVED8>
        <ITEMRESERVED9></ITEMRESERVED9>
        <ITEMRESERVED10></ITEMRESERVED10>
        <ITEMOVDESC>{{$warehouse_order->item_t->itemovdesc}}</ITEMOVDESC>
        <UNITPRICE>{{$warehouse_order->rate}}</UNITPRICE>
        <DISCPC></DISCPC>
        <TAXCODES></TAXCODES>
        <DEPTID>{{$warehouse_order->company_branch->depid}}</DEPTID>
        <QTYSHIPPED>0</QTYSHIPPED>
      </ITEMLINE>
      <SONO>{{$warehouse_order->order_id}}</SONO>
      <SODATE>{{$warehouse_order->tgl_kegiatan}}</SODATE>
      <TAX1ID>T</TAX1ID>
      <TAX1CODE>T</TAX1CODE>
      <TAX2CODE></TAX2CODE>
      <TAX1RATE>10</TAX1RATE>
      <TAX2RATE>0</TAX2RATE>
      <TAX1AMOUNT>0</TAX1AMOUNT>
      <TAX2AMOUNT>0</TAX2AMOUNT>
      <RATE>1</RATE>
      <TAXINCLUSIVE>0</TAXINCLUSIVE>
      <CUSTOMERISTAXABLE>1</CUSTOMERISTAXABLE>
      <CASHDISCOUNT>0</CASHDISCOUNT>
      <CASHDISCPC></CASHDISCPC>
      <FREIGHT>0</FREIGHT>
      <TERMSID>Net 14</TERMSID>
      <FOB></FOB>
      <ESTSHIPDATE>{{$warehouse_order->tgl_kegiatan}}</ESTSHIPDATE>
      <DESCRIPTION>{{$warehouse_order->remark}}</DESCRIPTION>
      <SHIPTO1>{{$warehouse_order->customers_warehouse->name}}</SHIPTO1>
      <SHIPTO2>{{$warehouse_order->customers_warehouse->address}}</SHIPTO2>
      <SHIPTO3></SHIPTO3>
      <SHIPTO4></SHIPTO4>
      <SHIPTO5></SHIPTO5>
      <DP>0</DP>
      <DPACCOUNTID>211</DPACCOUNTID>
      <DEPUSED></DEPUSED>
      <CUSTOMERID>{{$warehouse_order->customers_warehouse->personno}}</CUSTOMERID>
      <PONO>{{$warehouse_order->contract_no}}</PONO>
      <SALESMANID>
        <LASTNAME></LASTNAME>
        <FIRSTNAME>{{$warehouse_order->sales_name_whs->sales_name}}</FIRSTNAME>
        {{-- <FIRSTNAME></FIRSTNAME> --}}
      </SALESMANID>
      <CURRENCYNAME>Rupiah</CURRENCYNAME>
    </SALESORDER>
  </TRANSACTIONS>
</NMEXML>