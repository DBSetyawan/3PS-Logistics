function RemoveDetailItemOrdersWithoutDiscount(button) {
        
    /**
     * @func Tidak ada discount
     */
    const toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 6000
        });

        let row = $(button).closest("TR");

        let detialnote = row.find('#detailnotes').text();
        let itemovdesc = row.find('#itemov').text();
        let sub_services = row.find('#uid_services').text();

        let Qty = $("TD", row).eq(2).html();
        let Price = $("TD", row).eq(3).html();
        let TotalPrice = $("TD", row).eq(4).html();
        
        let PriceOnly = Price.replace(/\D/g, '');
        let QtyOnly = Qty.replace(/\D/g, '');
        let TotalPriceOnly = TotalPrice.replace(/\D/g, '');

        let hasilpengurangan = $("#subtotal").text()
        let hasilpenguranganOnly = hasilpengurangan.replace(/\D/g, '')

        let values = new Array();
        let CheckSubtotalZero = parseFloat(hasilpenguranganOnly) - parseFloat(TotalPriceOnly)

        $('#itemID').children('option').each(function() {
        var itemID = $(this).text();
                if (values.indexOf(itemID) === -1) {
                
                    CheckSubtotalZero !== 0 ? values.push(itemID) : $("#itemID option[value='" + sub_services + "']").remove();

                        if(!$.isEmptyObject(values)){

                            if (values.indexOf(itemID) === -1) {

                                $("#itemID option[value='" + sub_services + "']").remove();

                            } else {

                                $("#itemID option[value='" + sub_services + "']").remove();

                            }
                        }

                } else {

                    $(this).remove()
                }
            }
        )

        $('#qtyID').children('option').each(function() {
        var QtysQ = $(this).text();

                if (values.indexOf(QtysQ) === -1) {
        
                    CheckSubtotalZero !== 0 ? values.push(QtysQ) : $("#qtyID option[value='" + QtyOnly + "']").remove();

                        if(!$.isEmptyObject(values)){

                            if (values.indexOf(QtysQ) === -1) {
                                
                                $("#qtyID option[value='" + QtyOnly + "']").remove();

                            } else {

                                $("#qtyID option[value='" + QtyOnly + "']").remove();

                            }
                            
                        }

                } else {

                    $(this).remove()
                }
            }
        )

        $('#priceID').children('option').each(function() {

        var harga = $(this).text();
                if (values.indexOf(harga) === -1) {
        
                    CheckSubtotalZero !== 0 ? values.push(harga) : $("#priceID option[value='" + PriceOnly + "']").remove();

                        if(!$.isEmptyObject(values)){

                            if (values.indexOf(harga) === -1) {
                                
                                $("#priceID option[value='" + PriceOnly + "']").remove();
                                
                            } else {
                                
                                $("#priceID option[value='" + PriceOnly + "']").remove();

                            }

                        }

                } else {

                    $(this).remove()
                }
            }
        )

        $('#topup').children('option').each(function() {
        var topUPSXx = $(this).text();
                if (values.indexOf(topUPSXx) === -1) {
        
                    CheckSubtotalZero !== 0 ? values.push(topUPSXx) : $("#topup option[value='" + TotalPriceOnly + "']").remove();

                        if(!$.isEmptyObject(values)){

                            if (values.indexOf(topUPSXx) === -1) {
                                
                                $("#topup option[value='" + TotalPriceOnly + "']").remove();
                                
                            } else {
                                
                                $("#topup option[value='" + TotalPriceOnly + "']").remove();
                                    
                            }

                        }

                } else {

                    $(this).remove()
                }
            }
        )

        $('#detailnotesID').children('option').each(function() {
        var detailNotesUX = $(this).text();

                if (values.indexOf(detailNotesUX) === -1) {
            
                    CheckSubtotalZero !== 0 ? values.push(detailNotesUX) : $("#detailnotesID option[value='" + detialnote + "']").remove();

                            if(!$.isEmptyObject(values)){

                                if (values.indexOf(detailNotesUX) === -1) {
                                
                                    $("#detailnotesID option[value='" + detialnote + "']").remove();
                                    
                                } else {
                                    
                                    $("#detailnotesID option[value='" + detialnote + "']").remove();

                                }

                            }

                } else {

                    $(this).remove()
                }
            }
        )

        const hstl = formatMoney(parseFloat(hasilpenguranganOnly) - parseFloat(TotalPriceOnly))
        $("#subtotal").html(`<span>Rp. ${hstl}</span>`)
        
        const table = $("#itemList")[0];
        table.deleteRow(row[0].rowIndex);
        row.parents("tr").remove();

        DecrementLimit()

        $("#method").html(`<span class="badge badge-important">Model Rate - Not Found</span>`)

        $('#method').animate('slideFromRight scaleTo', {
            "custom": {
                "slideFromRight": {
                "duration": 3000,
                "delay": 50,
                "direction": "normal"
                }
            }
        });
        
    };