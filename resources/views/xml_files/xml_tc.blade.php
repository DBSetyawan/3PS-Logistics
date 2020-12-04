<?php print '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<NMEXML EximID="490" BranchCode="238055809" ACCOUNTANTCOPYID="">
  <TRANSACTIONS OnError="CONTINUE">
  @foreach ($transport_orders as $transport_lists)
    <SALESORDER operation="Add" REQUESTID="1">
      <TRANSACTIONID>26620</TRANSACTIONID>
      <ITEMLINE operation="Add">
        <keyID>0</keyID>
        <ITEMNO>{{$transport_lists->itemtransports->item_code}}</ITEMNO>
        <QUANTITY>{{$transport_lists->collie}}</QUANTITY>
        <ITEMUNIT></ITEMUNIT>
        <UNITRATIO>1</UNITRATIO>
        <ITEMRESERVED1></ITEMRESERVED1>
        <ITEMRESERVED2>{{$transport_lists->actual_weight}}</ITEMRESERVED2>
        <ITEMRESERVED3></ITEMRESERVED3>
        <ITEMRESERVED4></ITEMRESERVED4>
        <ITEMRESERVED5></ITEMRESERVED5>
        <ITEMRESERVED6></ITEMRESERVED6>
        <ITEMRESERVED7></ITEMRESERVED7>
        <ITEMRESERVED8></ITEMRESERVED8>
        <ITEMRESERVED9></ITEMRESERVED9>
        <ITEMRESERVED10></ITEMRESERVED10>
        <ITEMOVDESC>{{$transport_lists->notes}}</ITEMOVDESC>
        <UNITPRICE></UNITPRICE>
        <DISCPC></DISCPC>
        <TAXCODES></TAXCODES>
        <DEPTID>{{$transport_lists->company_branch->depid}}</DEPTID>
        <QTYSHIPPED>0</QTYSHIPPED>
      </ITEMLINE>
      <SONO>{{$transport_lists->order_id}}</SONO>
      <SODATE>{{$transport_lists->created_at}}</SODATE>
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
      <ESTSHIPDATE>{{$transport_lists->created_at}}</ESTSHIPDATE>
      <DESCRIPTION>{{$transport_lists->notes}}</DESCRIPTION>
      <SHIPTO1>{{$transport_lists->customers->name}}</SHIPTO1>
      <SHIPTO2>{{$transport_lists->customers->address}}</SHIPTO2>
      <SHIPTO3></SHIPTO3>
      <SHIPTO4></SHIPTO4>
      <SHIPTO5></SHIPTO5>
      <DP>0</DP>
      <DPACCOUNTID>211</DPACCOUNTID>
      <DEPUSED></DEPUSED>
      <CUSTOMERID>{{$transport_lists->customers->personno}}</CUSTOMERID>
      <PONO>{{$transport_lists->order_id}}</PONO>
      <SALESMANID>
        <LASTNAME></LASTNAME>
        <FIRSTNAME>AGUNG</FIRSTNAME>
      </SALESMANID>
      <CURRENCYNAME>Rupiah</CURRENCYNAME>
    </SALESORDER>
  @endforeach
  </TRANSACTIONS>
</NMEXML>