<?php

namespace warehouse\Http\Controllers\Services;

use Illuminate\Http\Request;

interface AccuratecloudInterface
{
    
    public function FuncOpenmoduleAccurateCloudItemList(
                        $attributeFields,
                        $attributeitemType
                    );

    public function FuncOpenmoduleAccurateCloudUsersBranchId();
                    
    public function FuncOpenmoduleAccurateCloudListSalesQoutation(
                        $attributeFields
                    );  

    public function FuncOpenmoduleAccurateCloudListPemasok(
                        $attributeFields
                    );

    public function FuncOpenmoduleAccurateCloudListBarangJasa(
                        $attributeFields
                    );  

    public function FuncOpenmoduleAccurateCloudListSalesOrders(
                        $attributeFields
                    ); 
                    
    public function FuncOpenmoduleAccurateCloudResetDetailItem($codeshipment, $branch_id, $attritemID_status, $itemNo, $listerFetchIDPRIMARY, $itemID, $transport_id);

    public function FuncOpenmoduleAccurateCloudUpdateSalesOrders(
                        $attritemIDaccurate,
                        $attrBranch,
                        $attrPelanggan,
                        $attrIdTransport,
                        $attributedetailnotes,
                        $attributeNumber,
                        $attributeID,
                        $attributedetailItemID,
                        $attributekuantitas,
                        $attributeprice,
                        $attritemIDinternalaccurate,
                        $attridAccurateSH
                    );
                    
    public function FuncOpenmoduleAccurateCloudUpdateBarangJasa(
                        $attributeitemID,
                        $attributeminimumQuantity,
                        $attributeCost
                    );
                    
    public function FuncOpenmoduleAccurateCloudUpdateBarangJasaCustomers(
                        $attributeitemID,
                        $attributeminimumQuantity,
                        $attributeCost,
                        $attributeName
                    );
                    
    public function FuncOpenmoduleAccurateCloudUpdateSalesQoutation(
                        $attributeqty,
                        $attributeID,
                        $attributedetailItemID,
                        $attributedetailprice,
                        $attributecomments
                    );
                    
    public function FuncOpenmoduleAccurateCloudDetailSalesQoutation(
                        $attributePrimaryAccurateSQ,
                        $attribute_TS
                    );  

    public function FuncOpenmoduleAccurateCloudDetailPemasok(
                        $attributePrimaryAccuratePemasok
                    );

    public function FuncOpenmoduleAccurateCloudDetailCustomers(
                        $attributePrimaryAccurateCustomers,
                        $attribute_TS
                    );

    public function FuncOpenmoduleAccurateCloudDetailBarangJasa(
                        $attributePrimaryAccurateSQ,
                        $attribute_TS
                    );  

    public function FuncOpenmoduleAccurateCloudDetailSalesOrders(
                        $attributePrimaryAccurateSO,
                        $attribute_TS
                    );
                    
    public function FuncModulesSessionAlwaysOn();

    public function FuncAlwaysOnSessionAccurateCluod();

    public function FuncAuthorizedAccurateCloud(
                        $attributeClientID,
                        $attributeResponseType,
                        $attributeRedirectURI,
                        $attributeScope
                    );
    public function FuncOpenmoduleAccurateCloudDblist(
                        $attribute_TS
                    );
                    
    public function FuncOpenmoduleAccurateCloudSession();

    public function FuncOpenmoduleAccurateCloudSaveItemBarangjasa__(
                        $attributeName,
                        $attributeitemType,
                        $attribute_TS,
                        $attribute_kodeUnik,
                        $attributeunit1Name
                    );
    public function FuncOpenmoduleAccurateCloudShowDetailDatabase(
                        $attributeSession,
                        $attributeID,
                        $attribute_TS
                    );
    public function FuncOpenmoduleAccurateCloudSaveCustomer(
                        $attributebranchId,
                        $attributecustomerNo,
                        $attributeName,
                        $attributeDetailName,
                        $attributeTransDate,
                        $attributeEmail,
                        $attributeHomePhone,
                        $attributeMobilePhone,
                        $attributeWebsite,
                        $attributeFaximili,
                        $attributePenagihan,
                        $attributekotaPenagihan,
                        $attributebillZipCode,
                        $attributebillProvince,
                        $attributebillCountry,
                        $attributeWhatsapp,
                        $attributenpwpNo,
                        $attributecustomerTaxType
                    );
    public function FuncOpenmoduleAccurateCloudUpdateCustomer(
                        $attributeID,
                        // $attributecustomerNo,
                        $attributeName
                        // $attributeDetailName,
                        // $attributeTransDate,
                        // $attributeEmail,
                        // $attributeHomePhone,
                        // $attributeMobilePhone,
                        // $attributeWebsite,
                        // $attributeFaximili,
                        // $attributePenagihan,
                        // $attributekotaPenagihan,
                        // $attributebillZipCode,
                        // $attributebillProvince,
                        // $attributebillCountry,
                        // $attributeWhatsapp,
                        // $attributenpwpNo,
                        // $attributecustomerTaxType
                    );
    public function FuncOpenmoduleAccurateCloudUpdatePemasok(
                        $attributeID,
                        $attributeName
                    );
    public function FuncOpenmoduleAccurateCloudSaveSalesOrders(
                        $attributeNumberIdentity,
                        $attributebranchId,
                        $attributeCustomerNo,
                        $attributeItemNo,
                        $attributeTransDate,
                        // $attributeSalesQoutation,
                        $attributeunitPrice,
                        $attributeQty,
                        $attributeTransportshipment,
                        $attributedetailNotes
                    );
    public function FuncOpenmoduleAccurateCloudSaveSalesQoutation(
                        $attributeNumberIdentity,
                        $attributeCustomerNo,
                        $attributeItemNo,
                        $attributeTransDate,
                        $attributeUnitPrice,
                        $attributequantity,
                        $attributeItemUnit,
                        $attributeTransportID,
                        $attributeDetailNotes,
                        $attributeCashDiscount
                    );
    public function FuncOpenmoduleAccurateCloudAllMasterCustomerList(
                        $attributeFields
                    );

    public function FuncOpenmoduleAccurateCloudfindMasterCustomerID(
                        $attributeSession,
                        $attributeID,
                        $attribute_TS
                    );
    public function FuncOpenmoduleAccurateCloudSaveDeliveryOrders(
                        $attributeNumberIdentity,
                        $attributeCustomerNo,
                        $attributeTransDate,
                        $attributeItemNo,
                        $attributeSalesQoutation,
                        $attributeSalesOrders,
                        $attributeItemUnit,
                        $attributequantity,
                        $attributeprice,
                        $attributeTransport_id,
                        $attributedetailNotes
                    );
    public function FuncOpenmoduleAccurateCloudSaveSalesInvoice(
                        $attributeCustomerNo,
                        $attributeItemNo,
                        $attributeorderDownPaymentNumber,
                        $attributereverseInvoice,
                        $attributetaxDate,
                        $attributetaxNumber,
                        $attributetransDate,
                        $attributeSalesOrdersSI,
                        $attributeSalesQoutationSI,
                        $attributeSalesDeliveryDO,
                        $attributeunitPrice,
                        $attributequantity,
                        $attributeitemUnitName
                    );
    public function FuncOpenmoduleAccurateCloudSaveSalesReceipt(
                        $attributeBankNo,
                        $attributechequeAmount,
                        $attributecustomerNo,
                        $attributeinvoiceNo,
                        $attributepaymentAmount,
                        $attributetransDate
                    );
    public function FuncOpenmoduleAccurateCloudSaveVendor(
                        $attributeName,
                        $attributeDetailName,
                        $attributeTransDate,
                        $attributeEmail,
                        $attributeHomePhone,
                        $attributeMobilePhone,
                        $attributeWebsite,
                        $attributeFaximili,
                        $attributePenagihan,
                        $attributekotaPenagihan,
                        $attributebillZipCode,
                        $attributebillProvince,
                        $attributebillCountry,
                        $attributeWhatsapp,
                        $attributenpwpNo,
                        $attributecustomerTaxType
                    );
                    
    public function FuncModuleReceivedWebhook(Request $req);


    
}