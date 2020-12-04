  // $("transport_order").validate();
    // $(".saved_origin").change(function () {
    //     $("select option").prop("disabled", false);
    //     $(".saved_origin").not($(this)).find("option[value='" + $(this).val() + "']").prop("disabled", true);
    // });
    //** https://github.com/rstacruz/nprogress **//
    // NProgress.configure({ easing: 'ease', speed: 200 });
    // NProgress.inc(true);
    // $("#transport_order").validationEngine();
    $.prototype.enable = function () {
        $.each(this, function (index, el) {
            $(el).removeAttr('disabled');
        });
    }

    $.prototype.disable = function () {
        $.each(this, function (index, el) {
            $(el).attr('disabled', 'disabled');
        });
    }

    // let cleave = new Cleave('.input-element', {
    //     numeral: true,
    //     numeralThousandsGroupStyle: 'thousand'
    // });
    
    let phone_origin = new Cleave('.input-phone-origin', {
        phone: true,
        phoneRegionCode: 'ID'
    });

    let phone_destination = new Cleave('.input-phone-destination', {
        phone: true,
        phoneRegionCode: 'ID'
    });

    let phone_origin_address = new Cleave('.input-phone-origin-address', {
        phone: true,
        phoneRegionCode: 'ID'
    });

    let phoneCustomer = new Cleave('.input-phone-origin-address-customer', {
        phone: true,
        phoneRegionCode: 'ID'
    });

    let phoneCustomerx = new Cleave('.input-phone-origin-address-customer-x', {
        phone: true,
        phoneRegionCode: 'ID'
    });

    let phoneCustomerv = new Cleave('.input-phone-origin-address-customer-v', {
        phone: true,
        phoneRegionCode: 'ID'
    });

    let phoneCustomertlf = new Cleave('.input-phone-origin-address-customer-telf', {
        phone: true,
        phoneRegionCode: 'ID'
    });

        //TODO: update validation input customer
        $("#add_master_customer").click(function(event) {
            event.preventDefault();

            $("#add_master_customer").prop( "disabled", true )
            $("#add_master_customer").text('Wait processing..'); 

                    let customer_name = $("#project_name").val();
                    let code = $("#code_project").val();
                    let since = $("#since").val();
                    let director = $("#director").val();
                    let type_of_business = $("#type_of_business").val();

                    let npwp = $("#tax_no").val();
                    let tax_address = $("#tax_address").val();
                    let tax_phone = $("#tax_phone").val();
                    let tax_city = $("#tax_city").val();
                    let tax_fax = $("#tax_fax").val();

                    let address = $("#address").val();
                    let kota = $("#kota").val();
                    let phone = $("#phone").val();
                    let fax = $("#fax").val();
                    let email = $("#email").val();
                    let website = $("#website").val();

                    let bank_name = $("#bank_name").val();
                    let no_rek = $("#no_rek").val();
                    let an_bank = $("#an_bank").val();
                    let term_of_payment = $("#term_of_payment").val();

                    let taxtype = $("#CustomerTaxType").val();
                    let kodepos = $("#ops_kodepos").val();
                    let provin = $("#provinceops").val();

                    let almtpnghb = $("#alamatpenagihan").val();
                    let almtpnghprvn = $("#penagihanPRV").val();
                    let almtpnghcty = $("#penagihanKOTA").val();
            
                    // if(!customer_name || !director) {

                        // swal("System Detects","Pastikan sudah terisi semua !","error");
                        // $("#add_master_customer").prop( "disabled", false)
                        // $("#add_master_customer").text('Save');
                    // } else {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        let project = customer_name;
                        let tahun = since;
                        let code_project = code;
                        let tax_no = npwp;
                        let direktur = director;
                        let tipe_bisnis = type_of_business;
                        let tax_nomor = tax_no;
                        let tax_alamat = tax_address;
                        let tax_telephone = tax_phone;
                        let tax_kota = tax_city;
                        let tax_faxs = tax_fax;
                        let alamat = address;
                        let ops_kota = kota;
                        let ops_phone = phone;
                        let ops_fax = fax;
                        let ops_email = email;
                        let ops_webs = website;
                        let nama_bank = bank_name;
                        let nomor_rekening = no_rek;
                        let atas_nama_bank = an_bank;
                        let kebijakan_pembayaran = term_of_payment;
                        let CustomerTaxType = taxtype;
                        let ops_kodepos = kodepos;
                        let provinceops = provin;

                        let pengihanPRV = almtpnghprvn;
                        let PNGHN_alamat = almtpnghb;
                        let PNGHcty = almtpnghcty;

                        let request = $.ajax({
                        
                            url: "/save-master-customer",
                            method: "GET",
                            dataType: "json",
                            data: {
                                pengihanPRV:pengihanPRV,
                                PNGHN_alamat:PNGHN_alamat,
                                PNGHcty:PNGHcty,
                                CustomertaxType:CustomerTaxType,
                                tax_no:tax_no,
                                ops_kodepos:ops_kodepos,
                                provinceops:provinceops,
                                project:project,
                                tahun:tahun,
                                code_project:code_project,
                                direktur:direktur,
                                tipe_bisnis: tipe_bisnis,
                                tax_nomor: tax_nomor,
                                tax_alamat: tax_alamat,
                                tax_telephone: tax_telephone,
                                tax_kota: tax_kota,
                                tax_faxs: tax_faxs,
                                alamat: alamat,
                                ops_kota: ops_kota,
                                ops_phone: ops_phone,
                                ops_fax: ops_fax,
                                ops_email: ops_email,
                                ops_webs: ops_webs,
                                nama_bank: nama_bank,
                                nomor_rekening: nomor_rekening,
                                atas_nama_bank: atas_nama_bank,
                                kebijakan_pembayaran: kebijakan_pembayaran
                            },
                            success: function (data) {

                                Swal({
                                    title: 'Successfully',
                                    allowOutsideClick: false,
                                    text: "You have done save Customers!",
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Okay!',
                                }).then((result) => {
                                    if (result.value) {

                                        setTimeout(() => $('#add_customer').modal('hide'), 2500);
                                        // do domething else with response 
                                        // $('#add_customer').modal('hide');
                                            // clear field after success saved data request!
                                            const provinceops = $("#provinceops");
                                            const provincenpwp = $("#provincenpwp");
                                            const customer_name = $("#project_name");
                                            const since = $("#since");
                                            const director = $("#director");
                                            const type_of_business = $("#type_of_business");

                                            const tax_no = $("#tax_no");
                                            const tax_address = $("#tax_address");
                                            const tax_phone = $("#tax_phone");
                                            const tax_city = $("#tax_city");
                                            const tax_fax = $("#tax_fax");

                                            const address = $("#address");
                                            const kota = $("#kota");
                                            const phone = $("#phone");
                                            const fax = $("#fax");
                                            const email = $("#email");
                                            const website = $("#website");

                                            const bank_name = $("#bank_name");
                                            const no_rek = $("#no_rek");
                                            const an_bank = $("#an_bank");
                                            const term_of_payment = $("#term_of_payment");


                                            provincenpwp.empty();
                                            provinceops.empty();
                                            customer_name.val('');
                                            since.val('');
                                            director.val('');
                                            type_of_business.empty();

                                            tax_no.val('');
                                            tax_address.val('');
                                            tax_phone.val('');
                                            tax_city.empty();
                                            tax_fax.val('');

                                            address.val('');
                                            kota.empty();
                                            phone.val('');
                                            fax.val('');
                                            email.val('');
                                            website.val('');

                                            bank_name.val('');
                                            no_rek.val('');
                                            an_bank.val('');
                                            term_of_payment.val('');
                                        
                                        setTimeout(() =>
                                        
                                            window.location.reload()
                                        
                                        , 3500);

                                    }
                                    
                                })
                                    
                        },
                        complete:function(data){

                            $("#add_master_customer").prop( "disabled", false)
                            $("#add_master_customer").text('Save');
                         
                        },
                            error: function(jqXhr, json, errorThrown){
                                let responses = $.parseJSON(jqXhr.responseText).errors;
                                errorsHtml = '<div class="alert alert-danger"><ul>';

                                if(!$.isEmptyObject(responses.tahun)){

                                    $.each( responses.tahun, function( key, value ) {
                                            $(".StartEnd").html('');
                                            $(".StartEnd").append(value);
                                            $(".Sinces").show();

                                        }
                                    );

                                } 
                                    else
                                        {
                                            $(".StartEnd").html('');
                                            $(".Sinces").hide()
                                }

                                if(!$.isEmptyObject(responses.tax_no)){
                                    
                                    $.each( responses.tax_no, function( key, value ) {
                                            $(".inputNpwp").html('');
                                            $(".inputNpwp").append(value);
                                            $(".npwp").show();

                                        }
                                    );

                                } 
                                    else
                                        {
                                            $(".inputNpwp").html('');
                                            $(".npwp").hide();
                                }
                                
                                $.each( responses, function( key, value ) {
                                    // errorsHtml +=  value[0] +'<br/>';
                                    if(key == "project"){
                                        $(".Customer").html('<label class="Customer control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "tax_no"){ //nomor pajak
                                        $(".npwp").html('<label class="npwp control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "tax_kota"){
                                        $(".tax_citys").html('<label class="tax_citys control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "tax_alamat"){
                                        $(".tax_alamatss").html('<label class="tax_alamatss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "ops_kota"){
                                        $(".ops_kotass").html('<label class="ops_kotass control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "alamat"){
                                        $(".alamatops").html('<label class="alamatops control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "nama_bank"){
                                        $(".nama_bankss").html('<label style="width:235px" class="nama_bankss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "atas_nama_bank"){
                                        $(".atas_nama_bankss").html('<label style="width:235px" class="atas_nama_bankss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "nomor_rekening"){
                                        $(".nomor_rekeningss").html('<label style="width:235px" class="nomor_rekeningss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "kebijakan_pembayaran"){
                                        $(".kebijakan_pembayaranss").html('<label class="Custkebijakan_pembayaranssomer control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "tipe_bisnis"){
                                        $(".tipe_bisnisss").html('<label style="width:235px" class="tipe_bisnisss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "CustomertaxType"){
                                        $(".CustomertaxTypess").html('<label style="width:235px" class="CustomertaxTypess control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "ops_kodepos"){
                                        $(".ops_kodeposss").html('<label style="width:235px" class="ops_kodeposss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "provinceops"){
                                        $(".provinceopsss").html('<label style="width:235px" class="provinceopsss control-label error"><i class="icon-exclamation-sign popovers alert-danger></i></label>');
                                    }
                                    if(key == "PNGHN_alamat"){
                                        $(".PNGHN_alamatss").html('<label class="PNGHN_alamatss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "PNGHcty"){
                                        $(".PNGHctyss").html('<label class="PNGHctyss control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }
                                    if(key == "pengihanPRV"){
                                        $(".pengihanPRVss").html('<label style="width:235px" class="CustopengihanPRVssmer control-label error"><i class="icon-exclamation-sign popovers alert-danger"></i></label>');
                                    }

                                });
                                // errorsHtml += '</ul></div>';
                                // Swal({
                                //     title: "Code Error " + jqXhr.status + ': ' + errorThrown,
                                //     text: "Maaf proses upload gagal diproses !",
                                //     confirmButtonColor: '#3085d6',
                                //     html: errorsHtml,
                                //     width: 'auto',
                                //     confirmButtonText: 'Confirm',
                                //     // showCancelButton: true,
                                //     type: 'error'
                                //         }).then((result) => {
                                //         if (result.value) {
                                //             return false;
                                //         }
                                //     })
                            }
                        }
                    );
            });

    // let phone_destination_address = new Cleave('.input-phone-destination-address', {
    //     phone: true,
    //     phoneRegionCode: 'ID'
    // });
    // $(".myInputs").enable();
    // TODO: visible disabled input
    $("#origin").disable();
    $("#origin_address").disable();
    $("#pic_phone_origin").disable();
    $("#pic_name_origin").disable();
    $("#origin_city").disable();

    $("#destination").disable();
    $("#destination_address").disable();
    $("#pic_phone_destination").disable();
    $("#pic_name_destination").disable();
    $("#destination_city").disable();

    let vars;

    function LoaderLoading() {
        vars = setTimeout(initialize, 3000);
    }

        $(function() {
            $('input[name="etd"]').daterangepicker({
                singleDatePicker: true,
                startDate: new Date(),
                showDropdowns: true,
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 10,
                autoUpdateInput: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                    locale: {
                    format: 'YYYY-MM-DD HH:mm',
                    "applyLabel": "Terapkan",
                    "cancelLabel": "Batal",
                    "parentEl": "date",
                },
            });
        });

        $(document).on('click', '.closeme', function() {
            swal.clickConfirm();
        });
        
        $(function() {
            $('input[name="eta"]').daterangepicker({
                singleDatePicker: true,
                startDate: new Date(),
                showDropdowns: true,
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 10,
                autoUpdateInput: true,
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    locale: {
                        format: 'YYYY-MM-DD HH:mm',
                        "applyLabel": "Terapkan",
                        "cancelLabel": "Batal",
                        "parentEl": "date",
                    },
            });
        });

        $(document).ready(function() {
            $('#btnPickers_etd').click(function (e) {
                e.preventDefault();
                $(function() {
                    $('input[name="etd"]').data('daterangepicker').show()
                    });
                });
            });
        $(document).ready(function() {
        $('#btnPickers_eta').click(function (e) {
            e.preventDefault();
            $(function() {
                $('input[name="eta"]').data('daterangepicker').show()
                });
            });
        });
       
    function initialize() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("myDiv").style.display = "block";
    }
    
        $(document).ready(function(){
           $("#tax_no").keypress(function(data){
             if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
             {
               $("#tax_no").html('errors')
               return false;
             }
           });
        });
           $(document).ready(function(){
             $("#tax_phone").keypress(function(data){
               if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
               {
                 $("#tax_phone").html('errors')
                 return false;
               }
             });
         });
           $(document).ready(function(){
             $("#no_rek").keypress(function(data){
               if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
               {
                 $("#no_rek").html('errors')
                 return false;
               }
             });
         });
           $(document).ready(function(){
             $("#term_of_payment").keypress(function(data){
               if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
               {
                 $("#term_of_payment").html('errors')
                 return false;
               }
             });
         });
                 $(document).ready(function(){
                   $("#phone").keypress(function(data){
                     if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                     {
                       $("#phone").html('errors')
                       return false;
                     }
                   });
               });
           $(document).ready(function(){
             $("#tax_fax").keypress(function(data){
               if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
               {
                 $("#tax_fax").html('errors')
                 return false;
               }
             });
         });
        $(document).ready(function(){
            $("#fax").keypress(function(data){
                if(data.which!=8 && data.which!=0 && (data.which<48 || data.which>57))
                {
                $("#fax").html('errors')
                return false;
                }
            });
        });
       $("#since").datepicker( {
            dateFormat: 'dd/mm/yy',
            viewMode: "years",
            minViewMode: "years"
       });
         $('.type_of_business').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/search_type_of_business',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
               return {
                 results:  $.map(data, function (item) {
                   return {
                     text: item.industry,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           });

           $('.provins').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/cari_province',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
               return {
                 results:  $.map(data, function (item) {
                   return {
                     text: item.name,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           }).on('change', function(e){
               const id = e.target.value;
                $('.kotaNPWP').select2({
                placeholder: 'Cari...',
                ajax: {
                url: '/cari_province/find/'+ id,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                    })
                };
                },
              cache: true
              }
           })
           });

           $('.kotaNPWP').select2({
                placeholder: 'Cari...',
           })

           $('.kotaOps').select2({
                placeholder: 'Cari...',
           })

           $('.provinsOps').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/cari_province',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
               return {
                 results:  $.map(data, function (item) {
                   return {
                     text: item.name,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           }).on('change', function(e){
               const id = e.target.value;
                $('.kotaOps').select2({
                placeholder: 'Cari...',
                ajax: {
                url: '/cari_province/find/'+ id,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                    })
                    };
                },
                cache: true
                }
            })
           });

           
    $(document).ready(function () {
        $("#collie").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#collie").html('errors')
                return false;
            }
        });
    });

    $(document).ready(function () {
        $("#qty").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#qty").html('errors')
                return false;
            }
        });
    });
    
    $(document).ready(function () {
        $("#volume").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#volume").html('errors')
                return false;
            }
        });
    });

    $(document).ready(function () {
        $("#actual_weight").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#actual_weight").html('errors')
                return false;
            }
        });
    });

    $(document).ready(function () {
        $("#chargeable_weight").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#chargeable_weight").html('errors')
                return false;
            }
        });
    });

        $('body').on('keydown', 'input, select, textarea', function(e) {
            var self = $(this)
            , form = self.parents('form:eq(0)')
            , focusable
            , next
            , prev
            ;

        if (e.shiftKey) {
            if (e.keyCode == 13) {
                focusable = form.find('input,a,select,button,textarea').filter(':visible');
                prev = focusable.eq(focusable.index(this)-1); 

                if (prev.length) {
                    prev.focus();
                } else {
                    form.submit();
                }
            }
        }
        else
            if (e.keyCode == 13) {
                focusable = form.find('input,a,select,button,textarea').filter(':visible');
                next = focusable.eq(focusable.index(this)+2);
                if (next.length) {
                    next.focus();
                } else {
                    form.submit();
                }
                return false;
            }
        });

        $("#m_add_address_book").click(function(event) {
            $("#m_add_address_book").prop( "disabled", true )
            $("#m_add_address_book").text('processing..');
            event.preventDefault();
            const toast = Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 6500
                        }
                    );
            let customers = $("#customers_name").val();

            let origin = $("#origin_names").val();
            let destination = $("#destination_names").val();

            let origin_city = $("#origin_citys").val();
            let destination_city = $("#destination_citys").val();
            
            let origin_address = $("#origin_add_boo").val();
            let destination_address = $("#destination_add_boo").val();

            let origin_fone = $("#origin_fone").val();
            let destination_fone = $("#destination_fone").val();

            let origin_pic = $("#origin_pic").val();
            let destination_pic = $("#destination_pic").val();

            if(!customers || !origin || !origin_city || !origin_address || !origin_fone || !origin_pic){
                $("#m_add_address_book").text('processing.. ');
                setTimeout(() => $("#m_add_address_book").text('Save'), 1000);
                $("#m_add_address_book").prop( "disabled", false )
                   
                toast({
                            title: `Pastikan customer, address origin/destination terisi !`
                        }
                    )
                  
            } else{
             
                    getData(customers);
            }
        });

        async function getData(customers) {
                
            const toast = Swal.mixin({
                            toast: true,
                            position: 'top',
                            showConfirmButton: false,
                            timer: 6500
                        }
                    );

            // let customers = $("#customer").val();

            let origin_name = $("#origin_names").val();
            // let destination_name = $("#destination_names").val();

            // let destination_citys = $("#destination_citys").val();
            let origin_citys = $("#origin_citys").val();

            let origin_detail = $("#origin_detil").val();
            // let destination_detail = $("#destination_detil").val();

            let origin_contacts = $("#origin_contacts").val();
            // let destination_contacts = $("#destination_contacts").val();

            // let destination_add_boo = $("#destination_add_boo").val();
            let origin_add_boo = $("#origin_add_boo").val();

            let origin_pic = $("#origin_pic").val();
            // let destination_pic = $("#destination_pic").val();

            let origin_fone = $("#origin_fone").val();
            // let destination_fone = $("#destination_fone").val();

                const api = 'http://your-api.co.id/save-address-book-form-transport';
                const data = { 

                            token : "{{ csrf_token() }}",
                            customers: customers,

                            origin_name: origin_name,
                            // destination_name: destination_name,
                            
                            origin_city: origin_citys,
                            // destination_city: destination_citys,
                            
                            origin_detail: origin_detail,
                            // destination_detail: destination_detail,
                            
                            origin_contacts: origin_contacts,
                            // destination_contacts: destination_contacts,
                            
                            origin_add_boo: origin_add_boo,
                            // destination_add_boo: destination_add_boo,

                            origin_fone: origin_fone,
                            // destination_fone: destination_fone,

                            origin_pic: origin_pic,
                            // destination_pic: destination_pic
                            
                        };

            try 
                {
                        // allowrd with mode cors with API of other apps
                        const response = await fetch(api, {

                                method: 'POST',
                                cache: 'no-cache',
                                credentials: 'same-origin',
                                redirect: 'follow',
                                referrer: 'no-referrer',
                                body: JSON.stringify(data),
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                    'Content-Type': 'application/json'
                            }

                        });

                    const json = await response.json();
                    let promise = new Promise((resolve, reject) => {
                        setTimeout(() => resolve(json), 1000)
                    });

                        let results = await promise;

                                toast({
                                    title: results.success
                                }
                            )

                    $("#customer").empty();

                    $("#origin_names").val('');
                    // $("#destination_names").val('');

                    // $("#destination_citys").empty();
                    $("#origin_citys").empty();

                    $("#origin_detil").val('');
                    // $("#destination_detil").val('');

                    $("#origin_contacts").val('');
                    // $("#destination_contacts").val('');

                    // $("#destination_add_boo").val('');
                    $("#origin_add_boo").val('');

                    $("#origin_pic").val('');
                    // $("#destination_pic").val('');

                    $("#origin_fone").val('');
                    // $("#destination_fone").val('');
                    
                    $("#m_add_address_book").prop( "disabled", false)
                    $("#m_add_address_book").text('Save');

                    setTimeout(() => $('#add_address_book').modal('hide'), 1500);

                        console.log('Success:', JSON.stringify(results.success));

                } 
                        catch (error) {
                            
                            toast({
                                title: `Data gagal disimpan <br> `+ error
                            }
                        )
            
                        $("#m_add_address_book").prop( "disabled", false)
                        setTimeout(() =>  $("#m_add_address_book").text('Save'), 1000);
                            
                        console.error('Error:', error);

                    }

        }

        $("#modal_drest").click(function(event) {

            if($("#customers_name").val() !== null) {

            let customer_id = $("#customers_name").val();
            $("#saved_origin").prop("disabled", false);
            // $("#saved_destination").prop("disabled", false);

            $.prototype.enable = function () {
                $.each(this, function (index, el) {
                    $(el).removeAttr('disabled');
                });
            }
            
            // let el = document.getElementById('idappends');
            // el.setAttribute("class", "hidden");
            $("#rate").prop("disabled", true);
            $("#qty").prop("disabled", true);
            // $("#eta").prop("disabled", true);
            // $("#etd").prop("disabled", true);
            $("#time_zone").prop("disabled", true);
            $("#collie").prop("disabled", true);
            $("#volume").prop("disabled", true);
            $("#actual_weight").prop("disabled", true);
            $("#chargeable_weight").prop("disabled", true);
            $("#notes").prop("disabled", true);

            // $("#saved_origin").empty();
            $("#rate").val('');
            $("#eta").val('');
            $("#etd").val('');
            $("#qty").val('');
            $("#total_rate").val('');
            $("#collie").val('');
            $("#volume").val('');
            $("#actual_weight").val('');
            $("#chargeable_weight").val('');
            $("#notes").val('');

             // hidden if value is exists
              // origin
            $('#destination_error').show();
            $('#destination_pic_name_errors').show();
            $('#pic_phone_destination_errors').show();
            $('#destination_phone_errors').show();
            $('#destination_contact_errors').show();
            $('#destination_address_error').show();
            $('#destination_detail_error').show();
            $('#destination_city_error').show();
        
            $("#saved_destination").empty();
            $("#destination").val('');
            $("#destination_address").val('');
            $("#pic_phone_destination").val('');
            $("#pic_name_destination").val('');
            $("#destination_city").empty();


            $('#sub_servicess').prop("disabled", true);
            $('#sub_servicess').empty();
            $('#items_tc').empty();
            $('#items_tc').prop("disabled", true);
            
            $("#destination").enable();
            $("#destination_address").enable();
            $("#pic_phone_destination").enable();
            $("#pic_name_destination").enable();
            $("#destination_city").enable();

            // $("#origin").val('');
            // $("#origin_address").val('');
            // $("#pic_phone_origin").val('');
            // $("#pic_name_origin").val('');
            // $("#origin_city").empty();
                
            // event origin
            $('.saved_destination').select2({
            placeholder: 'Cari...',
            // allowClear: true,
            "language": {
            "noResults": function(){
                // return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
                        return "Make sure the customer has an address book";
                }       
                    },
                        escapeMarkup: function (markup) {
                            return markup;
                        },
                        ajax: {
                            url: '/search_address_book_with_customers/find/'+ customer_id,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        // console.log(JSON.stringify(item));
                                        return {
                                            text: item.name + ' - ' +item.address,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                            cache: true,
                        }
                    }).on('change', function(e) {
                         
                    $.prototype.enable = function () {
                        $.each(this, function (index, el) {
                            $(el).removeAttr('disabled');
                        });
                    }
                //     let el = document.getElementById('idappends');
                // el.setAttribute("class", "");
                    nbsp = '&nbsp;';
                    // TODO: visible disabled input
                    $(".append_this").html(nbsp);
                    // nbsp = '&nbsp;';
                    // TODO: visible disabled input
                    // $(".append_this").html(nbsp);
                    // $(".myInputs").enable();
                    // TODO: visible disabled input
                    $("#destination").enable();
                    $("#destination_address").enable();
                    $("#pic_phone_destination").enable();
                    $("#pic_name_destination").enable();
                    $("#destination_city").enable();
    
                    $('.items_tc').prop("disabled", true);
                    $('#items_tc').empty();
                    $('#rate').val('');
                    $('.saved_origin').prop("disabled", false);
                    // $('#destination_city_error').show();

                    // $.get('/search_by_value_selected_destination/find/'+$("#saved_destination").val()+'/customerid/'+ customer_id, function(d){
                        if($('#saved_origin').val() == $('#saved_destination').val()){

                            // hidden if value is exists
                            $('#origin_city_error').show();
                            $('#origin_error').show();
                            $('#origin_detail_error').show();
                            $('#origin_address_error').show();
                            $('#origin_contact_errors').show();
                            $('#origin_phone_errors').show();
                            $('#origin_pic_name_errors').show();
                            $('#pic_phone_origin_errors').show();
            
                            // $('.sd').empty();
                            $('#saved_origin').empty();
                            $('#origin').val('');
                            $('#origin_detail').val('');
                            $('#origin_city').empty();
                            $('#id_origin_city').val('');
                            $('#pic_name_origin').val('');
                            $('#pic_phone_origin').val('');
                            $('#origin_address').val('');
                            $('#origin_contact').val('');
                            $('#origin_phone').val('');
        
                        } else {

                        }

                // });
                let dasdxczc = $("#customers_name").val();

                    // $('#origin_phone').val('');
                    $('#items_tc').prop('disabled', false);
                        $('.saved_origin').select2({
                            placeholder: 'Cari...',
                            // "language": {
                            // "noResults": function(){
                            //          return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
                            //     }
                            // },
                            //     escapeMarkup: function (markup) {
                            //         return markup;
                            // },
                            ajax: {
                                url: '/search_by_value_selected_destination/find/'+$(this).val()+'/customerid/'+ dasdxczc,
                                dataType: 'json',
                                delay: 250,
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function (item) {
                                            // $('#origin').val(item.name);
                                            // $('#origin_detail').val(item.details);
                                            $('#destination_city').val(''+item.city_id);
                                            // $('#origin_contact').val(''+item.contact);
                                            return {
                                                text: item.name + ' - ' + item.address,
                                                id: item.id
                                            }
                                        })
                                    };
                                },
                                cache: true
                            }
                        });
                    });

                    
                    let destination = $("#destination_city").val();
                    let titikAwal = $('#origin_city').val();
    
                    getItemCustomerSync(customer_id, titikAwal, destination)
                        .then(SavedOrigin =>
                        SavedOrigin.forEach(function(entry) {
                            let arrCustomers = new Array();
                            let arrJSONID = new Array();
                            for (let i = 0; i < SavedOrigin.length; i++) {
                                arrCustomers.push(SavedOrigin[i]['customers']);
                            }
    
                            for (let i = 0; i < arrCustomers.length; i++) {
                                arrJSONID.push(JSON.stringify(arrCustomers[i]));
                                if(arrJSONID == "null"){

                                    let destination = $("#destination_city").val();
                                    let titikAwal = $('#origin_city').val();
                                    let daszxvzxv = $("#customers_name").val();

                                    $('#sub_servicess').select2({
                                    placeholder: 'Cari...',
                                    "language": {
                                    "noResults": function(){
                                            return "Sub services tidak ditemukan";
                                        }
                                    },
                                    escapeMarkup: function (markup) {
                                        return markup;
                                    },
                                    ajax: {
                                    url: '/cari_subservice_without_customers/find/'+ daszxvzxv +'/origin/'+ titikAwal + '/destination/' + destination,
                                    dataType: 'json',
                                    delay: 250,
                                    processResults: function (data) {
                                                return {
                                                    results: $.map(data, function (item) {
                                                        if(item.customers == null){
                                                            const publish = "PUBLISH";
                                                                    return {
                                                                        text: item.sub_services.name + ' - ' + publish,
                                                                        // id: item.origin
                                                                        id: item.id
                                                                    }
                                                            } 
                                                                else {
                                                                    const contracts = "CONTRACT";
                                                                    return {
                                                                        text: item.sub_services.name + ' - ' + contracts,
                                                                        // id: item.origin
                                                                        id: item.id
                                                                    }
                                                            }
                                                        })
                                                    };
                                                },
                                                    cache: true
                                                }
                                            }
                                        );
    
                                    break;
                                    
                                } else {

                                    let sdaczxgd = $("#customers_name").val();
                                    let destination = $("#destination_city").val();
                                    let titikAwal = $('#origin_city').val();

                                    $('#sub_servicess').select2({
                                        placeholder: 'Cari...',
                                        ajax: {
                                            // url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ Subj['citys'].id + '/destination/' + destination, 
                                            url: '/cari_subservice_without_customers/find/'+ sdaczxgd +'/origin/'+ titikAwal + '/destination/' + destination,
                                            dataType: 'json',
                                            delay: 250,
                                                processResults: function (data) {
                                                        return {
                                                            results: $.map(data, function (item) {
                                                                if(item.customers == null){
                                                                    const publish = "PUBLISH";
                                                                    return {
                                                                        text: item.sub_services.name + ' - ' + publish,
                                                                        // id: item.origin
                                                                        id: item.id
                                                                    }
    
                                                                } else {
                                                                    const contracts = "CONTRACT";
                                                                    return {
                                                                        text: item.sub_services.name + ' - ' + contracts,
                                                                        // id: item.origin
                                                                        id: item.id
                                                                    }
                                                                }
                                                            })
                                                        };
                                                    },
                                                    cache: true
                                                }
                                            }).on('change', function (e){
                                            let dasczxcvz = $("#customers_name").val();
                                            let destination = $("#destination_city").val();
                                            let titikAwal = $('#origin_city').val();
                                            $('#items_tc').prop("disabled", false);
                                            let sub_services_id = e.target.value; 
                                                $('#items_tc').select2({
                                                placeholder: 'Cari...',
                                                "language": {
                                                    "noResults": function(){
                                                            return "Mohon maaf item pada service yang anda pilih tidak ditemukan.";
                                                        }
                                                    },
                                                    escapeMarkup: function (markup) {
                                                        return markup;
                                                },
                                                ajax: {
                                                url: '/search_by_customers_with_origin_destinations/find/'+dasczxcvz+'/sb/'+sub_services_id+'/origin/'+ titikAwal +'/destination/' + destination,
                                                dataType: 'json',
                                                delay: 250,
                                                processResults: function (data) {
                                                    return {
                                                        results: $.map(data, function (item) {
                                                            return {
                                                                text: item.itemovdesc,
                                                                id: item.id
                                                            }
                                                        })
                                                    };
                                                },
                                                    cache: true
                                            }
                                        });
                                    });
                                }
                            }
                        })
                    );
                    
            } 
                else {
                    const alerts__ = Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        timer: 6500
                    });

                    alerts__({
                        title: 'Maaf customer masih kosong, Pastikan Customer tidak kosong!'
                })
            }
        });
        
        // $("#modal_drest").click(function(event) {
        //     if($("#customers_name").val() !== null) {

        //     let customer_id = $("#customers_name").val();
        //     // $("#saved_origin").prop("disabled", false);
        //     $("#saved_destination").prop("disabled", false);

        //     $.prototype.enable = function () {
        //         $.each(this, function (index, el) {
        //             $(el).removeAttr('disabled');
        //         });
        //     }
        //     // let el = document.getElementById('idappends');
        //     // el.setAttribute("class", "hidden");   
        //     $("#rate").prop("disabled", true);
        //     $("#qty").prop("disabled", true);
        //     $("#eta").prop("disabled", true);
        //     $("#etd").prop("disabled", true);
        //     $("#time_zone").prop("disabled", true);
        //     $("#collie").prop("disabled", true);
        //     $("#volume").prop("disabled", true);
        //     $("#actual_weight").prop("disabled", true);
        //     $("#chargeable_weight").prop("disabled", true);
        //     $("#notes").prop("disabled", true);

        //     // $("#customers_name").empty();
        //     $("#saved_destination").empty();
        //     $("#rate").val('');
        //     $("#eta").val('');
        //     $("#etd").val('');
        //     $("#qty").val('');
        //     $("#total_rate").val('');
        //     $("#collie").val('');
        //     $("#volume").val('');
        //     $("#actual_weight").val('');
        //     $("#chargeable_weight").val('');
        //     $("#notes").val('');

        //     $('#sub_servicess').prop("disabled", true);
        //     $('#sub_servicess').empty();
        //     $('#items_tc').empty();
        //     $('#items_tc').prop("disabled", true);
            
        //     // $("#origin").enable();
        //     // $("#origin_address").enable();
        //     // $("#pic_phone_origin").enable();
        //     // $("#pic_name_origin").enable();
        //     // $("#origin_city").enable();

        //     $("#destination").enable();
        //     $("#destination_address").enable();
        //     $("#pic_phone_destination").enable();
        //     $("#pic_name_destination").enable();
        //     $("#destination_city").enable();
        //     // $("#origin").val('');
        //     // $("#origin_address").val('');
        //     // $("#pic_phone_origin").val('');
        //     // $("#pic_name_origin").val('');
        //     // $("#origin_city").empty();
        //     // destination

        //     // origin
        //     // $('#origin_error').show();
        //     // $('#origin_pic_name_errors').show();
        //     // $('#pic_phone_origin_errors').show();
        //     // $('#origin_phone_errors').show();
        //     // $('#origin_contact_errors').show();
        //     // $('#origin_address_error').show();
        //     // $('#origin_detail_error').show();
        //     // $('#origin_city_error').show();

        // // event saved_destination
        // $.get('/search_by_value_selected_origin/find/'+$("#saved_origin").val()+'/customerid/'+ customer_id, function(d){
        //             if(!!d){
                         
        //                 $('#destination_error').show();
        //                 $('#destination_pic_name_errors').show();
        //                 $('#pic_phone_destination_errors').show();
        //                 $('#destination_phone_errors').show();
        //                 $('#destination_contact_errors').show();
        //                 $('#destination_address_error').show();
        //                 $('#destination_detail_error').show();
        //                 $('#destination_city_error').show();
                  
        //                 $("#saved_destination").empty();
        //                 $("#destination").val('');
        //                 $("#destination_address").val('');
        //                 $("#pic_phone_destination").val('');
        //                 $("#pic_name_destination").val('');
        //                 $("#destination_city").empty();


        //             } else {

        //                  console.log("ga ada")

        //             }
        //     });

        //     $('.saved_destination').select2({
        //         placeholder: 'Cari...',
        //         "language": {
        //         "noResults": function(){
        //                 return "Make sure the customer has an address book";
        //                 // return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
        //             }
        //         },
        //         escapeMarkup: function (markup) {
        //             return markup;
        //         },
        //         ajax: {
        //             url: '/search_address_book_with_customers/find/'+ customer_id,
        //             dataType: 'json',
        //             delay: 250,
        //             processResults: function (data) {
        //                 return {
        //                     results: $.map(data, function (item) {
        //                         // console.log(JSON.stringify(item));
        //                         return {
        //                             text: item.name + ' - ' +item.address,
        //                             id: item.id
        //                         }
        //                     })
        //                 };
        //             },
        //             cache: true,
        //         }
        //     }).on('change', function(e) {
            
        //             $.prototype.enable = function () {
        //                 $.each(this, function (index, el) {
        //                     $(el).removeAttr('disabled');
        //                 });
        //             }
        //             //     let el = document.getElementById('idappends');
        //             // el.setAttribute("class", "");
        //             nbsp = '&nbsp;';
        //             // TODO: visible disabled input
        //             $(".append_this").html(nbsp);
        //             // $(".myInputs").enable();
        //             // TODO: visible disabled input
        //             $("#destination").enable();
        //             $("#destination_address").enable();
        //             $("#pic_phone_destination").enable();
        //             $("#pic_name_destination").enable();
        //             $("#destination_city").enable();

        //             $('.items_tc').prop("disabled", true);
        //             $('#items_tc').empty();
        //             $('#rate').val('');
        //             $('.saved_origin').prop("disabled", false);

        //                     $.get('/search_by_value_selected_origin/find/'+$(this).val()+'/customerid/'+ customer_id, function(d){
        //                         if(!!d){
                                    
        //                             $('#origin_error').show();
        //                             $('#origin_pic_name_errors').show();
        //                             $('#pic_phone_origin_errors').show();
        //                             $('#origin_phone_errors').show();
        //                             $('#origin_contact_errors').show();
        //                             $('#origin_address_error').show();
        //                             $('#origin_detail_error').show();
        //                             $('#origin_city_error').show();
                            
        //                             $("#saved_origin").empty();
        //                             $("#origin").val('');
        //                             $("#origin_address").val('');
        //                             $("#pic_phone_origin").val('');
        //                             $("#pic_name_origin").val('');
        //                             $("#origin_city").empty();

        //                         }
        //                 });
  
        //             // $('#origin_phone').val('');
        //             // $('#origin_phone').val('');
        //             $('#items_tc').prop('disabled', false);
        //             $('.saved_origin').select2({
        //                 placeholder: 'Cari...',
        //                 "language": {
        //                 "noResults": function(){
        //                         return "Make sure the customer has an address book";
        //                     // return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
        //                     }
        //                 },
        //                 escapeMarkup: function (markup) {
        //                     return markup;
        //                 },
        //                 ajax: {
        //                     url: '/search_by_value_selected_destination/find/'+$(this).val()+'/customerid/'+ customer_id,
        //                     dataType: 'json',
        //                     delay: 250,
        //                     processResults: function (data) {
        //                         return {
        //                             results: $.map(data, function (item) {
        //                                 // $('#origin').val(item.name);
        //                                 // $('#origin_detail').val(item.details);
        //                                 $('#destination_city').val(''+item.city_id);
        //                                 // $('#origin_contact').val(''+item.contact);
        //                                 return {
        //                                     text: item.name + ' - ' + item.address,
        //                                     id: item.id
        //                                 }
        //                             })
        //                         };
        //                     },
        //                     cache: true
        //                 }
        //             });
        //         });
        //     } 
        //         else {

        //             const alerts__ = Swal.mixin({
        //                 toast: true,
        //                 position: 'top',
        //                 showConfirmButton: false,
        //                 timer: 6500
        //             });

        //             alerts__({
        //                 title: 'Maaf customer masih kosong, Pastikan Customer tidak kosong!'
        //         })
        //     }
        // });


        $("#modal_reset").click(function(event) {

            if($("#customers_name").val() !== null) {

            let customer_id = $("#customers_name").val();
            $("#saved_origin").prop("disabled", false);
            // $("#saved_destination").prop("disabled", false);

            $.prototype.enable = function () {
                $.each(this, function (index, el) {
                    $(el).removeAttr('disabled');
                });
            }
            
            // let el = document.getElementById('idappends');
            // el.setAttribute("class", "hidden");
            $("#rate").prop("disabled", true);
            $("#qty").prop("disabled", true);
            // $("#eta").prop("disabled", true);
            // $("#etd").prop("disabled", true);
            $("#time_zone").prop("disabled", true);
            $("#collie").prop("disabled", true);
            $("#volume").prop("disabled", true);
            $("#actual_weight").prop("disabled", true);
            $("#chargeable_weight").prop("disabled", true);
            $("#notes").prop("disabled", true);

            // clear field origin
            $("#saved_origin").empty();
            $("#origin").val('');
            $("#origin_address").val('');
            $("#pic_phone_origin").val('');
            $("#pic_name_origin").val('');
            $("#origin_city").empty();
            $('#origin_error').show();

            // alert error
            $('#origin_pic_name_errors').show();
            $('#pic_phone_origin_errors').show();
            $('#origin_phone_errors').show();
            $('#origin_contact_errors').show();
            $('#origin_address_error').show();
            $('#origin_detail_error').show();
            $('#origin_city_error').show();
            
            $("#rate").val('');
            $("#eta").val('');
            $("#etd").val('');
            $("#qty").val('');
            $("#total_rate").val('');
            $("#collie").val('');
            $("#volume").val('');
            $("#actual_weight").val('');
            $("#chargeable_weight").val('');
            $("#notes").val('');

            $('#sub_servicess').prop("disabled", true);
            $('#sub_servicess').empty();
            $('#items_tc').empty();
            $('#items_tc').prop("disabled", true);
            
            $("#origin").enable();
            $("#origin_address").enable();
            $("#pic_phone_origin").enable();
            $("#pic_name_origin").enable();
            $("#origin_city").enable();

            // $("#origin").val('');
            // $("#origin_address").val('');
            // $("#pic_phone_origin").val('');
            // $("#pic_name_origin").val('');
            // $("#origin_city").empty();

                    // event origin
        $('.saved_origin').select2({
            placeholder: 'Cari...',
            // allowClear: true,
            "language": {
            "noResults": function(){
                // return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
                return "Make sure the customer has an address book";
            }
            },
                escapeMarkup: function (markup) {
                    return markup;
                },
                ajax: {
                    url: '/search_address_book_with_customers/find/'+ customer_id,
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                // console.log(JSON.stringify(item));
                                return {
                                    text: item.name + ' - ' +item.address,
                                    id: item.id
                                }
                            })
                        };
                    },
            cache: true,
                }
                    }).on('change', function(e) {
                         const originVals = e.target.value;
                    $.prototype.enable = function () {
                        $.each(this, function (index, el) {
                            $(el).removeAttr('disabled');
                        });
                    }
                //     let el = document.getElementById('idappends');
                // el.setAttribute("class", "");
                    // nbsp = '&nbsp;';
                    // TODO: visible disabled input
                    // $(".append_this").html(nbsp);
                    // nbsp = '&nbsp;';
                    // TODO: visible disabled input
                    // $(".append_this").html(nbsp);
                    // $(".myInputs").enable();
                    // TODO: visible disabled input
                    $("#origin").enable();
                    $("#origin_address").enable();
                    $("#pic_phone_origin").enable();
                    $("#pic_name_origin").enable();
                    $("#origin_city").enable();
    
                    $('.items_tc').prop("disabled", true);
                    $('#items_tc').empty();
                    $('#rate').val('');
                    $('.saved_destination').prop("disabled", false);
                    // $('#destination_city_error').show();

                    // $.get('/search_by_value_selected_origin/find/'+$('#saved_destination').val()+'/customerid/'+ customer_id, function(d){
                       
                    //    console.log(d[0])
                    //    console.log($('#saved_destination').val())
                        if($('#saved_origin').val() == $('#saved_destination').val()){
                            console.log("sama")
                            $('#destination_city_error').show();
                            $('#destination_error').show();
                            $('#destination_detail_error').show();
                            $('#destination_address_error').show();
                            $('#destination_contact_errors').show();
                            $('#destination_phone_errors').show();
                            $('#destination_pic_name_errors').show();
                            $('#pic_phone_destination_errors').show();
            
                            // $('.sd').empty();
                            $('#saved_destination').empty();
                            $('#destination').val('');
                            $('#destination_detail').val('');
                            $('#destination_city').empty();
                            $('#id_destination_city').val('');
                            $('#pic_name_destination').val('');
                            $('#pic_phone_destination').val('');
                            $('#destination_address').val('');
                            $('#destination_contact').val('');
                            $('#destination_phone').val('');
                        } else {
                            console.log("ga sama")

                        }
                            
                       
                // });
                let dasczxcvsadacxzcfasz = $("#customers_name").val();

                    // $('#origin_phone').val('');
                    $('#items_tc').prop('disabled', false);
                        $('.saved_destination').select2({
                            placeholder: 'Cari...',
                            // "language": {
                            // "noResults": function(){
                            //          return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
                            //     }
                            // },
                            //     escapeMarkup: function (markup) {
                            //         return markup;
                            // },
                            ajax: {
                                url: '/search_by_value_selected_destination/find/'+$(this).val()+'/customerid/'+ dasczxcvsadacxzcfasz,
                                dataType: 'json',
                                delay: 250,
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function (item) {
                                            // $('#origin').val(item.name);
                                            // $('#origin_detail').val(item.details);
                                            $('#origin_city').val(''+item.city_id);
                                            // $('#origin_contact').val(''+item.contact);
                                            return {
                                                text: item.name + ' - ' + item.address,
                                                id: item.id
                                            }
                                        })
                                    };
                                },
                                cache: true
                            }
                        });
                    });
                    let titikAwal = $('#origin_city').val();
    
                    getItemCustomerSync(customer_id, titikAwal, destination)
                        .then(SavedOrigin =>
                        SavedOrigin.forEach(function(entry) {
                            let arrCustomers = new Array();
                            let arrJSONID = new Array();
                            for (let i = 0; i < SavedOrigin.length; i++) {
                                arrCustomers.push(SavedOrigin[i]['customers']);
                            }

                            let dasczxvzx = $("#customers_name").val();
                            let destination = $("#destination_city").val();
                            let titikAwal = $('#origin_city').val();

                            for (let i = 0; i < arrCustomers.length; i++) {
                                arrJSONID.push(JSON.stringify(arrCustomers[i]));
                                if(arrJSONID == "null"){
                                    $('#sub_servicess').select2({
                                    placeholder: 'Cari...',
                                    "language": {
                                    "noResults": function(){
                                            return "Sub services tidak ditemukan";
                                        }
                                    },
                                    escapeMarkup: function (markup) {
                                        return markup;
                                    },
                                        ajax: {
                                        url: '/cari_subservice_without_customers/find/'+ dasczxvzx +'/origin/'+ titikAwal + '/destination/' + destination,
                                        dataType: 'json',
                                        delay: 250,
                                            processResults: function (data) {
                                                return {
                                                    results: $.map(data, function (item) {
                                                        if(item.customers == null){
                                                            const publish = "PUBLISH";
                                                                    return {
                                                                        text: item.sub_services.name + ' - ' + publish,
                                                                        // id: item.origin
                                                                        id: item.id
                                                                    }
                                                            } 
                                                              else {
                                                                    const contracts = "CONTRACT";
                                                                    return {
                                                                        text: item.sub_services.name + ' - ' + contracts,
                                                                        // id: item.origin
                                                                        id: item.id
                                                                    }
                                                                }
                                                        })
                                                    };
                                                },
                                                    cache: true
                                                }
                                            }
                                        );
    
                                    break;
                                    
                                } else {

                                    let dasdagvdasd = $("#customers_name").val();
                                    let destination = $("#destination_city").val();
                                    let titikAwal = $('#origin_city').val();

                                    $('#sub_servicess').select2({
                                        placeholder: 'Cari...',
                                        ajax: {
                                            // url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ Subj['citys'].id + '/destination/' + destination, 
                                            url: '/cari_subservice_without_customers/find/'+ dasdagvdasd +'/origin/'+ titikAwal + '/destination/' + destination,
                                            dataType: 'json',
                                            delay: 250,
                                                processResults: function (data) {
                                                        return {
                                                            results: $.map(data, function (item) {
                                                                if(item.customers == null){
                                                                    const publish = "PUBLISH";
                                                                    return {
                                                                        text: item.sub_services.name + ' - ' + publish,
                                                                        // id: item.origin
                                                                        id: item.id
                                                                    }
    
                                                                } else {
                                                                    const contracts = "CONTRACT";
                                                                    return {
                                                                        text: item.sub_services.name + ' - ' + contracts,
                                                                        // id: item.origin
                                                                        id: item.id
                                                                    }
                                                                }
                                                            })
                                                        };
                                                    },
                                                    cache: true
                                                }
                                            }).on('change', function (e){

                                            let dasgvdasd = $("#customers_name").val();
                                            let destination = $("#destination_city").val();
                                            let titikAwal = $('#origin_city').val();

                                            $('#items_tc').prop("disabled", false);
                                            let sub_services_id = e.target.value; 
                                                $('#items_tc').select2({
                                                placeholder: 'Cari...',
                                                "language": {
                                                    "noResults": function(){
                                                            return "Mohon maaf item pada service yang anda pilih tidak ditemukan.";
                                                        }
                                                    },
                                                    escapeMarkup: function (markup) {
                                                        return markup;
                                                },
                                                ajax: {
                                                url: '/search_by_customers_with_origin_destinations/find/'+dasgvdasd+'/sb/'+sub_services_id+'/origin/'+ titikAwal  +'/destination/' + destination,
                                                dataType: 'json',
                                                delay: 250,
                                                processResults: function (data) {
                                                    return {
                                                        results: $.map(data, function (item) {
                                                            return {
                                                                text: item.itemovdesc,
                                                                id: item.id
                                                            }
                                                        })
                                                    };
                                                },
                                                    cache: true
                                            }
                                        });
                                    });
                                }
                            }
                        })
                    );
                    
            } 
                else {
                    const alerts__ = Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        timer: 6500
                    });

                    alerts__({
                        title: 'Maaf customer masih kosong, Pastikan Customer tidak kosong!'
                })
            }
        });

        // FIXME: progress add customer on transport order with modal
        $(document).ready(function(){
            $("#add_customer").on('shown.bs.modal', function(){
                $(this).find('#project_name').focus();
            });
        });

        $(document).ready(function(){
            $("#add_address_book").on('shown.bs.modal', function(){
                $(this).find('#project_name').focus();
            });
        });

            // $("#modal_address_book").click(function(event) {
            // event.preventDefault();
                //         $("#add_item_customer").prop( "disabled", true )
                //         $("#add_item_customer").text('Wait processing..');

                //     $.ajaxSetup({
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //         }
                //     });


                //     let request = $.ajax({
                    
                //         url: "/save-item-customer-ajax/saved",
                //         method: "GET",
                //         dataType: "json",
                //         data: {
                //             gen_code:gen_code,
                //             Reqcustomer:Reqcustomer,
                //             Reqsubservice:Reqsubservice,
                //             Reqshipment_category: Reqshipment_category,
                //             Reqmoda: Reqmoda,
                //             Reqorigin: Reqorigin,
                //             Reqdestination: Reqdestination,
                //             Reqitemovdesc: Reqitemovdesc,
                //             Reqprice: Reqprice,
                //             Requnit: Requnit
                //         },
                //         success: function (data) {

                //             Swal({
                //                 title: 'Successfully',
                //                 text: "You have done save Item Customers!",
                //                 type: 'success',
                //                 confirmButtonColor: '#3085d6',
                //                 confirmButtonText: 'Okay!',
                //             }).then((result) => {
                //                 if (result.value) {
                                    
                //                     console.log(data.code_autogenerate)
                //                     $("#itemcode").val(data.code_autogenerate);
                //                 }
                                
                //             })
                                
                //     },
                //     complete:function(data){
                //         $("#add_item_customer").prop( "disabled", false)
                //         $("#add_item_customer").text('Save');
                        
                //     // clear field after success saved data request!
                //     $("#customerx").empty();
                //     $("#sub_service_id").empty();
                //     $("#shipmentx").empty();
                //     $("#moda_x").empty();
                //     $("#originx").empty();
                //     $("#destination_x").empty();
                //     $("#itemovdesc").val('');
                //     $("#unit").val('');
                //     $("#price").val('');

                //     },
                //         error: function(){

                //             Swal({
                //                     title: 'Error',
                //                     text: "You have done save Item Customers!",
                //                     type: 'error',
                //                     confirmButtonColor: '#3085d6',
                //                     confirmButtonText: 'Okay!',
                //                 }).then((result) => {
                //                     if (result.value) {
                                        
                //                         $("#add_item_customer").prop( "disabled", false)
                //                         $("#add_item_customer").text('Save');
                //                     }
                                    
                //             })
                        
                //         }
                //     }
                // );


            // });



        $("#add_item_customer").click(function(event) {

            $("#add_item_customer").prop( "disabled", true );
            $("#add_item_customer").text('Wait processing..');

            event.preventDefault();

                let customername = document.getElementById('customerx_id').value;
                let sub_service = document.getElementById('sub_service_id').value;
                let shipment_category = document.getElementById('shipmentx').value;
                let moda = document.getElementById('moda_x').value;
                let origin = document.getElementById('originx').value;
                let destination = document.getElementById('destination_x').value;
                let itemovdesc = document.getElementById('itemovdesc').value;
                let unit = document.getElementById('unit').value;
                let gen_code = document.getElementById('itemcode').value;
                let price = document.getElementById('price').value;
                
                let minimalQty = document.getElementById('minimalQty').value;
               
                let qtypertama = document.getElementById('qtyFirst').value;
                let RateFirst = document.getElementById('rateFirsts').value;
                // let RrateNext = document.getElementById('rateNext').value;

                if(!shipment_category || !sub_service || !shipment_category || !moda || !origin || !destination || !itemovdesc || !unit || !gen_code || !price ) {
                    setTimeout(() => $("#add_item_customer").prop( "disabled", false), 200 );
                    setTimeout(() => $("#add_item_customer").text('Save'),2500);
                    setTimeout(() => swal("Peringatan !","Pastikan sudah terisi semua !","error"), 3000);
                
                } else {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    let Reqcustomer = customername;
                    let Reqsubservice = sub_service;
                    let Reqprice = price;
                    let Reqshipment_category = shipment_category;
                    let Reqmoda = moda;
                    let Reqorigin = origin;
                    let Reqdestination = destination;
                    let Reqitemovdesc = itemovdesc;
                    let Requnit = unit;

                    let Qtyminimum = minimalQty;

                    let qtyPERTAMA = qtypertama;
                    let RatePertama = RateFirst;
                    // let RateSelanjutnya = RrateNext;

                    let request = $.ajax({
                    
                        url: "/save-item-customer-ajax/saved",
                        method: "GET",
                        dataType: "json",
                        data: {
                            gen_code:gen_code,
                            Reqcustomer:Reqcustomer,
                            Reqsubservice:Reqsubservice,
                            Reqshipment_category: Reqshipment_category,
                            Reqmoda: Reqmoda,
                            Reqorigin: Reqorigin,
                            Reqdestination: Reqdestination,
                            Reqitemovdesc: Reqitemovdesc,
                            Reqprice: Reqprice,
                            Requnit: Requnit,

                            Qtyminimum: Qtyminimum,

                            qtyPERTAMA: qtyPERTAMA,
                            RatePertama: RatePertama
                            // RateSelanjutnya: RateSelanjutnya,
                        },

                        success: function (data) {

                            Swal({
                                title: 'Successfully',
                                text: "Data berhasil menambahkan item customer!",
                                type: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Okay!',
                            }).then((result) => {
                                if (result.value) {
                                    
                                    setTimeout(() => $('#add_item').modal('hide'), 1500);

                                }
                                
                            })
                                   
                    },
                    complete:function(data){
                        $("#add_item_customer").prop( "disabled", false)
                        $("#add_item_customer").text('Save');
                        
                    // clear field after success saved data request!
                    $("#customerx").empty();
                    $("#sub_service_id").empty();
                    $("#shipmentx").empty();
                    $("#moda_x").empty();
                    $("#originx").empty();
                    $("#destination_x").empty();
                    $("#itemovdesc").val('');
                    $("#unit").val('');
                    $("#price").val('');

                    $("#rateFirsts").val('');
                    $("#rateFirsts").val('');
                    $("#minimalQty").val('');

                    },
                        error: function(){

                            Swal({
                                    title: 'Error',
                                    text: "You have done save Item Customers!",
                                    type: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Okay!',
                                }).then((result) => {
                                    if (result.value) {
                                        
                                        $("#add_item_customer").prop( "disabled", false)
                                         $("#add_item_customer").text('Save');
                                    }
                                    
                            })
                           
                        }
                    }
                );
            }

        });

        $('.citys').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_city',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
               return {
                 results:  $.map(data, function (item) {
                    //  console.log(item)
                   return {
                     text: item.name+' - '+item.province.name,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           });

           $('#unit').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/rest-api-units',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
               return {
                 results:  $.map(data, function (item) {
                    //  console.log(item)
                   return {
                     text: item.name,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           });

           $('.dtcstmers').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_customer',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
               return {
                 results:  $.map(data, function (item) {
                   return {
                     text: item.name,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           });
           $('.dtsubservices').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_sub_services',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
               return {
                 results:  $.map(data, function (item) {
                   return {
                     text: item.name,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           });

           $(document).ready(function() {

               $('#tab2').hide();
               $('#tab3').hide();
           });
           let formObj = document.getElementById('form_item_sub_services');
           
           $('.metodeX').select2({
                placeholder: 'Cari...',
            }).on("change", function(e){
                if(e.target.value == "metode2"){
                    
                        $('#tab2').delay(2500).fadeIn('slow');
                        let $el = $('#rateFirst');
                        $el.wrap('<form>').closest('form').get(0).reset();
                        $el.unwrap();
                        console.log( $("#form_item_sub_services").serializeArray() );
                        e.preventDefault();
                        formObj.rateFirsts.value = ''
                        $("#itemovdesc").val("");
                        $("#qtyFirst").val("");
                        $("#price").val("");
                        $('#tab3').delay(2500).fadeOut('slow');

                    } 
                        else {
                                if(e.target.value == "metode3"){

                                    $("#minimalQty").val("");
                                    $('#tab2').delay(2500).fadeOut('slow');
                                    $('#tab3').delay(2500).fadeIn('slow');
                                    $("#itemovdesc").val("");
                                    $("#price").val("");

                            } 
                                else 
                                        {

                                        $('#tab2').delay(2500).fadeOut('slow');
                                        $('#tab3').delay(2500).fadeOut('slow');
                                        
                                        $("#minimalQty").val("");
                                        $("#qtyFirst").val("");
                                        formObj.rateFirsts.value = ''
                                        $("#itemovdesc").val("");
                                        $("#price").val("");


                            }
                    } 
                }
            );

           $('.dtshipmentctgry').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/loaded_shipments_category',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
               return {
                 results:  $.map(data, function (item) {
                   return {
                     text: item.nama,
                     id: item.id
                   }
                 })
               };
              },
              cache: true
              }
           });

        //    $('#destination_x').on('change', function(e){
        //         let destination = e.target.value;
        //         $.get('/loaded_auto_search_txt/find/'+ destination, function(data){
        //             $.each(data, function(ix, ox){
        //                 $.get('/loaded_auto_search_txt/find/'+ $('#originx').val(), function(dax){
        //                     $.each(dax, function(ix, sdx){
        //                         $.get('/loaded_sub_services_idx/find/'+ $('#sub_service_id').val(), function(dxz){
        //                             $.each(dxz, function(ix, sdc){
        //                                 $.get('/loaded_shipments_category_idx/find/'+ $('#shipmentx').val(), function(dsxz){
        //                                     $.each(dsxz, function(ix, sdzx){
        //                                         $.get('/loads_moda/find/'+ $('#moda_x').val(), function(modid){
        //                                             $.each(modid, function(ix, idxkpmo){
        //                                                 $('#itemovdesc').val(''+sdc.name+' '+sdzx.nama+' '+idxkpmo.name+' pengiriman'+' dari '+sdx.name+' ke '+ox.name);
        //                                             });
        //                                         });
        //                                     });
        //                                 });
        //                             });
        //                         });
        //                     });
        //                 });
        //             })
        //         });
        //    });

        var autoExpand = function (field) {

            // Reset field height
            field.style.height = 'inherit';

            // Get the computed styles for the element
            var computed = window.getComputedStyle(field);

            // Calculate the height
            var height = parseInt(computed.getPropertyValue('border-top-width'), 24)
                        + parseInt(computed.getPropertyValue('padding-top'), 24)
                        + field.scrollHeight
                        + parseInt(computed.getPropertyValue('padding-bottom'), 24)
                        + parseInt(computed.getPropertyValue('border-bottom-width'), 24);

            field.style.height = height + 'px';

            };
            $("#itemovdesc").css("min-height", 120)
            document.addEventListener('input', function (event) {
            if (event.target.tagName.toLowerCase() !== 'textarea') return;
            autoExpand(event.target);
            }, false);

        let typingTimer;
        let doneTypingInterval = 1000; 
        $(document).ready('live', function (){
        $('#destination_x').on('change', function(e){
            let destination = e.target.value;
            $.get('/loaded_auto_search_txt/find/'+ destination, function(data){
                $.each(data, function(ix, ox){
                    $.get('/loaded_auto_search_txt/find/'+ $('#originx').val(), function(dax){
                        $.each(dax, function(ix, sdx){
                            $.get('/loaded_sub_services_idx/find/'+ $('#sub_service_id').val(), function(dxz){
                                $.each(dxz, function(ix, sdc){
                                    $.get('/loaded_shipments_category_idx/find/'+ $('#shipmentx').val(), function(dsxz){
                                        $.each(dsxz, function(ix, sdzx){
                                            $.get('/loads_moda/find/'+ $('#moda_x').val(), function(modid){
                                                $.each(modid, function(ix, idxkpmo){
                                                    let xss = ``
                                                        $('#price').keyup(function(e){
                                                            const metode = $("#metode").val();
                                                            e.preventDefault()
                                                            clearTimeout(typingTimer);
                                                            if(metode == "dflt"){
                                                                if ($('#price').val) {
                                                                    let unit1 = $("#unit").val();
                                                                            typingTimer = setTimeout(function(){
                                                                            xss = `( Rate: Rp. ${e.target.value}, Unit: ${unit1} )`
                                                                            $('#itemovdesc').val(''+sdc.name+' '+
                                                                                sdzx.nama+' '+
                                                                                idxkpmo.name+' pengiriman'+' dari '+sdx.name+' ke '+ox.name+xss);
                                                                            }, 
                                                                        doneTypingInterval 
                                                                    );
                                                                }
                                                            }
                                                            if(metode == "metode2"){
                                                                if ($('#minimalQty').val) {
                                                                    typingTimer = setTimeout(function(){
                                                                        let minimalQTx = $("#minimalQty").val();
                                                                        let unitx = $("#unit").val();
                                                                        xss = `( Qty Minimal: ${minimalQTx} ${unitx}, Rate: Rp. ${e.target.value} )`
                                                                        $('#itemovdesc').val(''+sdc.name+' '+
                                                                            sdzx.nama+' '+
                                                                            idxkpmo.name+' pengiriman'+' dari '+sdx.name+' ke '+ox.name+xss);
                                                                        }, 
                                                                    doneTypingInterval );
                                                                }
                                                            } 
                                                        if(metode == "metode3"){
                                                            if ($('#price').val || $('#rateFirsts').val || $("#qtyFirst").val) {
                                                                        typingTimer = setTimeout(function(){
                                                                        let price = $("#price").val();
                                                                        let minimalQT = $("#minimalQty").val();
                                                                        let qtyFirst = $("#qtyFirst").val();
                                                                        let unit = $("#unit").val();
                                                                        let metode = $("#metode").val();
                                                                        let rateFirsts = $("#rateFirsts").val();
                                                                            xss = `( Qty Minimal: ${qtyFirst} ${unit}, Rate: Rp. ${rateFirsts}, Rate Selanjutnya: Rp. ${e.target.value} )`
                                                                                $('#itemovdesc').val(''+sdc.name+' '+
                                                                                    sdzx.nama+' '+
                                                                                    idxkpmo.name+' pengiriman'+' dari '+sdx.name+' ke '+ox.name+xss);
                                                                                }, 
                                                                        doneTypingInterval
                                                                    );
                                                                }
                                                            }
                                                        });
                                                     }
                                                );
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                })
            });
       });
    });

$( document ).ready(function() {
        $({property: 0}).animate({property: 110}, {
            duration: 4500,
            step: function() {
                var _percent = Math.round(this.property);
                $('#progress').css('width',  _percent+"%");
                if(_percent == 200) {
                    $("#progress").addClass("done");
                }
            },
            complete: function() {
                $("#progress").hide();
            }
        });
    });
            $(function(){
                $('#box_g1').change(function(){
                    if($(this).attr('id') == 'box_g1' && $(this).val() == 'Default'){
                        $('.box_g1').not(this).prop('disabled', true).val('Disabled');
                    } else {
                        $('.box_g1').not(this).removeProp('disabled');
                        
                        $('.box_g1 option').removeProp('disabled');
                        $('.box_g1').each(function(){
                            var val = $(this).val();
                            if(val != 'Default' || val != 'Disabled'){
                                $('.box_g1 option[value="'+val+'"]').not(this).prop('disabled', true);
                            }
                        });
                    }
                });
            });
        
        // $(function() {
        //     $('input[name="eta"]').daterangepicker({
        //         singleDatePicker: true,
        //         startDate: new Date(),
        //         showDropdowns: true,
        //         timePicker: true,
        //         timePicker24Hour: true,
        //         timePickerIncrement: 10,
        //         autoUpdateInput: true,
        //         ranges: {
        //             'Today': [moment(), moment()],
        //             'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        //             'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        //             'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        //             'This Month': [moment().startOf('month'), moment().endOf('month')],
        //             'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        //         },
        //         locale: {
        //             format: 'YYYY-MM-DD HH:mm',
        //             "applyLabel": "Terapkan",
        //             "cancelLabel": "Batal",
        //             "parentEl": "date",
        //         },
        //     });
        // });

//  $(function() {
//         $("#etd").datepicker({
//             dateFormat: "yy-mm-dd",
//             onSelect: function(datetext){

//                 var d = new Date(); // for now

//                 var h = d.getHours();
//                 h = (h < 10) ? ("0" + h) : h ;

//                 var m = d.getMinutes();
//                 m = (m < 10) ? ("0" + m) : m ;

//                 var s = d.getSeconds();
//                 s = (s < 10) ? ("0" + s) : s ;

//                 datetext = datetext + " " + h + ":" + m + ":" + s;

//                 $('#etd').val(datetext);
//                 }
//         });
//     });
    
 $("#addcpics").click(function(event) {
    event.preventDefault();
    const name = $('#customer_namepp').val();
    const id = $('#id_customerd_pic').val();
    const statuspics = $('#statusid_pics').val();
    const id_customer = $('#id_customer').val();
    const position = $('#position_customer').val();
    const email = $('#email_customer').val();
    const phone = $('#phonepics').val();

    $.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                timeout: 1000,
                    cache: false,
                    error:function(x,e){
                        if(x.status==0){
                            alert('Anda sedang offline!\nSilahkan cek koneksi anda!');
                        }   else if(x.status==404){
                            alert('Permintaan URL tidak ditemukan!');
                        }   else if(x.status==500){
                                alert('Internal Server Error!');
                            }   else if(e=='parsererror'){
                                    alert('Error.\nParsing JSON Request failed!');
                        }   else if(e=='timeout'){
                                alert('Request Time out!');
                        }else {
                            alert('Error tidak diketahui: \n'+x.responseText);
                    }
                }
        });

    $.ajax({
        type: "post",
        url: "{{ url('customerpics') }}",
        dataType: "json",
        data: {
            id:id,
            customer_pic_status_id:statuspics,
            customer_id:id_customer,
            name:name,
            position:position,
            email:email,
            phone:phone
                  },
                    success: function (data) {
                        alert('Record updated successfully');
                            location.reload();
                    },
                // function( msg ) {
                // $("#ajaxResponse").append("<div>"+msg+"</div>");
            // },
        error: function(data){
             alert("Error")
        }
    });
});

//  $("#refresh").click(function(event) {
//     const customer = $('#customers_name').val();
//     const sb = $('#sub_servicess').val();
//     const origin = $('#id_origin_city').val();
//     const destination = $('#id_destination_city').val();
//     $('#items_tc').prop('disabled', false);
//     if (sb==null) {
//         $('#items_tc').prop("disabled", true);
//         alert("sub_service belum diisi.");
//     } else {
//             $.get('/search_by_customers_with_origin_destinations/find/'+customer+'/sb/'+sb+'/origin/'+origin+'/destination/'+destination, function(data){
//             $.each(data, function(index, Obj){
//                 $('#items_tc').append($('<option>' ,{
//                     value:Obj.id,
//                     text:Obj.itemovdesc
//                 }));
//                     $('#rate').val(Obj.price);
//             });
//         });
//     }

// });
// $("#refresh").click(function(event) {
//     const customer = $('#customers_name').val();
//     const sb = $('#sub_servicess').val();
//     const origin = $('#id_origin_city').val();
//     const destination = $('#id_destination_city').val();
//     $('#items_tc').prop('disabled', false);
//     if (sb==null) {
//         $('#items_tc').prop("disabled", false);
//         // alert("sub_service belum diisi.");
//         const toast = Swal.mixin({
//                     toast: true,
//                     position: 'top',
//                     showConfirmButton: false,
//                     timer: 6500
//               });

//         toast({
//             title: 'Maaf permintaan anda tidak bisa diproses, Pastikan Sub Services tidak kosong!'
//         })

//     } else {
//             // $.get('/search_by_customers_with_origin_destinations/find/'+customer+'/sb/'+sb+'/origin/'+origin+'/destination/'+destination, function(data){
//             // $.each(data, function(index, Obj){
//                 $('#items_tc').select2({
//                 placeholder: 'Cari...',
//                 ajax: {
//                         // url: '/list_transport/find/'+ data[0]['sub_services']['id'],
//                         url: '/search_by_customers_with_origin_destinations/find/'+customer+'/sb/'+sb,
//                         dataType: 'json',
//                         delay: 250,
//                         processResults: function (data) {
//                             return {
//                                 results: $.map(data, function (item) {
//                                     return {
//                                         text: item.itemovdesc,
//                                         id: item.id
//                                     }
//                                 })
//                             };
//                          },
//                     cache: true
//                 }
//             });
//         // });
//     }
// });

$('#items_tc').on('change', function(e){
    $("#rate").prop("disabled", false);
    $("#qty").prop("disabled", false);
    $("#eta").prop("disabled", false);
    $("#etd").prop("disabled", false);
    $("#time_zone").prop("disabled", false);
    $("#collie").prop("disabled", false);
    $("#volume").prop("disabled", false);
    $("#actual_weight").prop("disabled", false);
    $("#chargeable_weight").prop("disabled", false);
    $("#notes").prop("disabled", false);

    let items_index = e.target.value;
    $.get('/list-by-sub-services-price/find/'+ items_index, function(data){
        $.each(data, function(index, COL){
            $('#rate').val(COL.price);
        });
    });
});

// parsing value sub service inside moda
$('#sub_service_id').on('change', function(e){
    let item_sub_service = e.target.value;
    $('#moda_x').prop("disabled", false);
    $('#moda_x').empty();
    // $.get('/load-sub-service-ex-md/find/'+ item_sub_service, function(data){
        $('#moda_x').select2({
              placeholder: 'Cari...',
              ajax: {
              url: '/load-sub-service-ex-md/find/'+item_sub_service,
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
               return {
                 results: $.map(data, function (item) {
                   return {
                        text: item.name,
                        id: item.id
                   }
                 })
               };
              },
              cache: true
            }
        });
    // });
});

function testInput(event) {
   var value = String.fromCharCode(event.which);
   var pattern = new RegExp(/[a-zåäö ]/i);
   return pattern.test(value);
}

$('#uom').bind('keypress', testInput);
$('#customers_pics_error').delay(2000).fadeOut('slow');
$('#customers_name_error').delay(2500).fadeOut('slow');
$('#ssrvcs_error').delay(3000).fadeOut('slow');
$('#items_error').delay(3500).fadeOut('slow');


function test(params) {
    test = $('#remark').val();
    // alert(test);
    $('#totest').val(test);
}

    $('.sub_services').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/cari_subservice/find',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    //progress parsing customer->sub_services->item_transports
    // $('#sub_service').on('change', function(e){
    //     let sub_service = e.target.value;
    //     $.get('/list_transport/find/'+ sub_service, function(data){
    //         $('#items_tc').empty();
    //         $.each(data, function(index, Obj){
    //             $('#items_tc').append($('<option>' ,{
    //                 value:Obj.id,
    //                 text:Obj.name
    //             }));
    //         });
    //         //if you make multiple value, you just Include 'select2MultiCheckboxes' on id DOM
    //         $('.items_tc').select2({
    //             placeholder: 'Cari...',
    //             ajax: {
    //                     url: '/list_transport/find/'+ sub_service,
    //                     dataType: 'json',
    //                     delay: 250,
    //                     processResults: function (data) {
    //                         return {
    //                             results: $.map(data, function (item) {
    //                                 return {
    //                                     text: item.itemovdesc,
    //                                     id: item.id
    //                                 }
    //                             })
    //                         };
    //                      },
    //                 cache: true
    //             }
    //         });
    //     });
    // });

    //     $('#sub_service').on('change', function(e){
    //     let sub_service = e.target.value;
    //     $.get('/list_transport/find/'+ sub_service, function(data){
    //         $('#items_tc').empty();
    //         $.each(data, function(index, Obj){
    //             $('#items_tc').append($('<option>' ,{
    //                 value:Obj.id,
    //                 text:Obj.name
    //             }));
    //         });
    //         //if you make multiple value, you just Include 'select2MultiCheckboxes' on id DOM
    //         $('.items_tc').select2({
    //             placeholder: 'Cari...',
    //             ajax: {
    //                     url: '/list_transport/find/'+ sub_service,
    //                     dataType: 'json',
    //                     delay: 250,
    //                     processResults: function (data) {
    //                         return {
    //                             results: $.map(data, function (item) {
    //                                 return {
    //                                     text: item.itemovdesc,
    //                                     id: item.id
    //                                 }
    //                             })
    //                         };
    //                      },
    //                 cache: true
    //             }
    //         });
    //     });
    // });

    $('.customer_names').select2({
        placeholder: 'Cari...',
        "language": {
                "noResults": function(){
                    return "Nama customer tidak ditemukan.";
                }
        },
        escapeMarkup: function (markup) {
                        return markup;
                    },
        ajax: {
            url: '/cari_customers_transport/find',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                let arrCustomers = new Array();
                            let fetccustomers = new Array();
                    // for (let i = 0; i < data.length; i++) {
                    //     arrCustomers.push(data[i]);


                    return {
                            results: $.map(data, function (item) {
                        // console.log("results:",item.name)
                            
                                // if (item.suggestion = true) {
                                    // $('#city_customer').val('' + item.city.name);
                                    // $('#address').val('' + item.address);
                                    // $('#phone_customer').val('' + item.phone);
                                // } else {
                                        // $('#address').val('');
                                        // $('#phone_customer').val('');
                                    // }
                                    return {
                                        text: item.name,
                                        id: item.id
                                }
                            })
                        };
                    // }
                    // for (let i = 0; i < arrCustomers[1].length; i++) {
                    //     fetccustomers.push(arrCustomers[1][i]);
                    // console.log("results:",fetccustomers[i]['name'])
                    // break;
                        
                    // }

                // return {
                //     results: $.map(data, function (item) {
                       
                //         // if (item.suggestion = true) {
                //             // $('#city_customer').val('' + item.city.name);
                //             // $('#address').val('' + item.address);
                //             // $('#phone_customer').val('' + item.phone);
                //         // } else {
                //                 // $('#address').val('');
                //                 // $('#phone_customer').val('');
                //             // }
                //         //     return {
                //         //         text: item.name,
                //         //         id: item.id
                //         // }
                //     })
                // };
            },
            cache: true
        }
    });

    //regions deploy izzytransport
    //blm mapping ke BE, FE ok.
    $('.regions').select2({
        placeholder: 'Cari...',
        "language": {
                "noResults": function(){
                    return "Region tidak ditemukan.";
                }
        },
        escapeMarkup: function (markup) {
                        return markup;
                    },
        ajax: {
            url: '/cari_regions_transport/find',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                        results: $.map(data, function (item) {
                                return {
                                    text: item.region,
                                    id: item.region
                            }
                        })
                    };
                   
            },
            cache: true
        }
    });

    $('.customer_names').on('change', function(e){
        let tcs = e.target.value;
        $('.itemsadd').prop("disabled", false);

        // jika api accurate no-active
        $.get('/cari_customers_transport/find/'+ tcs, function(data){
            // console.log(data)
            $('#id_project').val(''+data.project_id);
            $('#customerx').val(''+data.name);
            $('#customerx_id').val(''+data.id);
        });
        // jika api accurate active
        // $.get('/get-id-customer-accourate-cloud/'+ tcs, function(data){
        //     // console.log(data.name)
        //     // $('#id_project').val(''+data.project_id);
        //     $('#customerx').val(''+data.name);
        //     $('#customerx_id').val(''+data.id);
        // });
        
        // $('.dtcstmers').select2({
        //       placeholder: 'Cari...',
        //       ajax: {
        //       url: '/search/list_customers_transports-icl/'+tcs,
        //       dataType: 'json',
        //       delay: 250,
        //       processResults: function (data) {
        //        return {
        //          results:  $.map(data, function (item) {
        //            return {
        //              text: item.name,
        //              id: item.id
        //            }
        //          })
        //        };
        //       },
        //       cache: true
        //     }
        // });
    });

    $('#origin_city').on('change', function(e){
        // let origin = e.target.value;
        nbsp = '&nbsp;';
        $(".append_this").html(nbsp);
        let origin = $('#origin_city').val();
        $.get('/load-city/find/'+ origin, function(data){
        $('#id_origin_city').val(''+data.id);
        $("#sub_servicess").empty();
        $("#items_tc").empty();
        $('#sub_servicess').prop("disabled", false);
        let des = $("#destination_city").val();
        let destination = $("#id_destination_city").val();
        let customer_id = $("#customers_name").val();
        let save_city = $("#id_origin_city").val();
        // let el = document.getElementById('idappends');
        // el.setAttribute("class", "");
     
            getItemCustomerSync(customer_id, data.id, destination)
                .then(originCitys => 
                    originCitys.forEach(function(entry) {
                    let arrCustomers = new Array();
                    let arrJSONID = new Array();
                    for (let i = 0; i < originCitys.length; i++) {
                        arrCustomers.push(originCitys[i]['customers']);
                    }

                    let sdadxcc = $("#customers_name").val();
                    let dsaxzczx = $("#destination_city").val();
                    let dsadxcz = $("#origin_city").val();

                    for (let i = 0; i < arrCustomers.length; i++) {
                        arrJSONID.push(JSON.stringify(arrCustomers[i]));
                        if(arrJSONID == "null"){
                         
                            $('#sub_servicess').select2({
                            placeholder: 'Cari...',
                            "language": {
                            "noResults": function(){
                                    return "Sub service tidak ditemukans";
                                }
                            },
                            escapeMarkup: function (markup) {
                                return markup;
                            },
                            ajax: {
                            url: '/cari_subservice_without_customers/find/'+ sdadxcc +'/origin/'+ dsadxcz + '/destination/' + dsaxzczx,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                    return {
                                        results: $.map(data, function (item) {
                                                if(item.customers == null){
                                                    const publish = "PUBLISH";
                                                    return {
                                                        text: item.sub_services.name + ' - ' + publish,
                                                        // id: item.origin
                                                        id: item.id
                                                    }
                                                } else {
                                                    const contracts = "CONTRACT";
                                                    return {
                                                        text: item.sub_services.name + ' - ' + contracts,
                                                        // id: item.origin
                                                        id: item.id
                                                    }
                                                }
                                            })
                                        };
                                    },
                                    cache: true
                                }
                            });
                            break;
                        } 
                            else {
                                let dsacxzcxz = $("#customers_name").val();
                                let sdaczxc = $("#destination_city").val();
                                let sdaczxcfds = $("#origin_city").val();

                                $('#sub_servicess').select2({
                                placeholder: 'Cari...',
                                    ajax: {
                                        url: '/cari_subservice_without_customers/find/'+ dsacxzcxz +'/origin/'+ sdaczxcfds + '/destination/' + sdaczxc,
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function (data) {
                                        return {
                                            results: $.map(data, function (item) {
                                                if(item.customers == null){
                                                    const publish = "PUBLISH";
                                                    return {
                                                        text: item.sub_services.name + ' - ' + publish,
                                                        // id: item.origin
                                                        id: item.id
                                                    }

                                                } else {
                                                    const contracts = "CONTRACT";
                                                    return {
                                                        text: item.sub_services.name + ' - ' + contracts,
                                                        // id: item.origin
                                                        id: item.id
                                                    }
                                                }
                                            })
                                        };
                                    },
                                    cache: true
                                }
                            }).on('change', function (e){
                            // $('#sub_servicess').empty();
                            $('#items_tc').prop("disabled", false);
                                let sub_services_id = e.target.value; 
                                let tAWAL = $("#origin_city").val();
                                let dsazxc = $("#customers_name").val();
                                let tAKHIR = $("#destination_city").val();
                                // console.log($("#sub_servicess").val())
                                $('#items_tc').select2({
                                        placeholder: 'Cari...',
                                        "language": {
                                            "noResults": function(){
                                                    return "Mohon maaf item pada service yang anda pilih tidak ditemukan.";
                                                }
                                            },
                                            escapeMarkup: function (markup) {
                                                return markup;
                                        },
                                        ajax: {
                                            // url: '/list_transport/find/'+ data[0]['sub_services']['id'],
                                        url: '/search_by_customers_with_origin_destinations/find/'+dsazxc+'/sb/'+sub_services_id+'/origin/'+ tAWAL +'/destination/' + tAKHIR,
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function (data) {
                                            return {
                                                    results: $.map(data, function (item) {
                                                        return {
                                                            text: item.itemovdesc,
                                                            id: item.id
                                                    }
                                                })
                                            };
                                        },
                                        cache: true
                                    }   
                                });
                            });
                        }
                    }
                })
            );
        });
    });


    $('#destination_city').on('change', function(e){
        nbsp = '&nbsp;';
        $(".append_this").html(nbsp);
        $("#sub_servicess").empty();
         $("#items_tc").empty();
        // let origin = $("#id_origin_city").val();
        let origin = $("#origin_city").val();
        let destination = $("#destination_city").val();
        const customer_id = $("#customers_name").val();
        // let el = document.getElementById('idappends');
        //     el.setAttribute("class", "");
            $("#sub_servicess").empty();
            $('#sub_servicess').prop("disabled", false);
            $("#items_tc").empty();
            $.get('/load-city/find/'+ destination, function(data){
                $('#id_destination_city').val(''+data.id);
                let save_destination = $("#destination_city").val();

                getItemCustomerSync(customer_id, origin, destination)
                    .then(destinationCity => 

                    destinationCity.forEach(function(entry) {
                        let arrCustomers = new Array();
                        let arrJSONID = new Array();
                        const customer = entry.customers;
                        const publish = entry;

                        for (let i = 0; i < destinationCity.length; i++) {
                            arrCustomers.push(destinationCity[i]['customers']);
                        }

                        for (let i = 0; i < arrCustomers.length; i++) {
                            arrJSONID.push(JSON.stringify(arrCustomers[i]));

                            if(arrJSONID == "null"){
                                let sdsad = $("#customers_name").val();
                                let origsdadin = $("#origin_city").val();

                                $('#sub_servicess').select2({
                                    placeholder: 'Cari...',
                                    "language": {
                                    "noResults": function(){
                                            return "Sub services tidak ditemukan";
                                        }
                                    },
                                    escapeMarkup: function (markup) {
                                        return markup;
                                    },
                                    ajax: {
                                    url: '/cari_subservice_without_customers/find/'+ sdsad +'/origin/'+ origsdadin + '/destination/' + save_destination,
                                    dataType: 'json',
                                    delay: 250,
                                    processResults: function (data) {
                                            return {
                                                results: $.map(data, function (item) {
                                                    if(item.customers == null){
                                                        const publish = "PUBLISH";

                                                            return {
                                                                text: item.sub_services.name + ' - ' + publish,
                                                                // id: item.origin
                                                                id: item.id
                                                            }
                                                        } 
                                                            else {
                                                                const contracts = "CONTRACT";
                                                                return {
                                                                    text: item.sub_services.name + ' - ' + contracts,
                                                                    // id: item.origin
                                                                    id: item.id
                                                                }
                                                        }
                                                    })
                                                };
                                            },
                                            cache: true
                                        }
                                    }
                                );
                                
                                break;

                            } else {
                                let cstmr = $("#customers_name").val();
                                let dasdxczxc = $("#origin_city").val();
                                
                                $('#sub_servicess').select2({
                                    placeholder: 'Cari...',
                                    ajax: {
                                    url: '/cari_subservice_without_customers/find/'+ cstmr +'/origin/'+ dasdxczxc + '/destination/' + save_destination,
                                    dataType: 'json',
                                    delay: 250,
                                    processResults: function (data) {
                                        return {
                                            results: $.map(data, function (item) {
                                                if(item.customers == null){
                                                    const publish = "PUBLISH";
                                                    return {
                                                        text: item.sub_services.name + ' - ' + publish,
                                                        // id: item.origin
                                                        id: item.id
                                                    }

                                                } else {
                                                    const contracts = "CONTRACT";
                                                    return {
                                                        text: item.sub_services.name + ' - ' + contracts,
                                                        // id: item.origin
                                                        id: item.id
                                                    }
                                                }
                                            })
                                        };
                                    },
                                    cache: true
                                }
                            }).on('change', function (e){
                            // $('#sub_servicess').empty();
                            let customer_idx = $("#customers_name").val();
                            let dasdxcz = $("#origin_city").val();

                            $('#items_tc').prop("disabled", false);
                            let destinations = $("#destination_city").val();
                                let sub_services_id = e.target.value; 
                                    $('#items_tc').select2({
                                            placeholder: 'Cari...',
                                            "language": {
                                                "noResults": function(){
                                                        return "Mohon maaf item pada service yang anda pilih tidak ditemukan.";
                                                    }
                                                },
                                                escapeMarkup: function (markup) {
                                                    return markup;
                                            },
                                            ajax: {
                                            url: '/search_by_customers_with_origin_destinations/find/'+customer_idx+'/sb/'+sub_services_id+'/origin/'+ dasdxcz +'/destination/' + destinations,
                                            dataType: 'json',
                                            delay: 250,
                                            processResults: function (data) {
                                                return {
                                                        results: $.map(data, function (item) {
                                                            return {
                                                                text: item.itemovdesc,
                                                                id: item.id
                                                        }
                                                    })
                                                };
                                            },
                                            cache: true
                                        }   
                                    });
                                });
                            }
                        }
                    })
                );
            });
        });

    $('.services').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/cari_service',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                        
                    })
                };
            },
            cache: true
        }
    });
    

    // changed contract vendor
    $('.customer_names').on('change', function(e){
        let asal = $("#origin_city").val();
        let tujuan = $("#destination_city").val();
        let customers_onload = e.target.value;
        $('#sub_servicess').select2({
            placeholder: 'Cari...',
            ajax: {
                url: '/cari_subservice_without_customers/find/'+ customers_onload +'/origin/'+ asal + '/destination/' + tujuan,
                dataType: 'json',
                delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                if(item.customers == null){
                                    const publish = "PUBLISH";
                                    return {
                                        text: item.sub_services.name + ' - ' + publish,
                                        // id: item.origin
                                        id: item.id
                                    }

                                } else {
                                    const contracts = "CONTRACT";
                                    return {
                                        text: item.sub_services.name + ' - ' + contracts,
                                        // id: item.origin
                                        id: item.id
                                    }
                                }
                            })
                        };
                    },
                    cache: true
                }
             }).on('change', function (e){
                let kotaC = $("#origin_city").val();
                let kotaD = $("#destination_city").val();
                $('#items_tc').prop("disabled", false);
                let sub_services_id = e.target.value; 
                $('#items_tc').select2({
                        placeholder: 'Cari...',
                        "language": {
                            "noResults": function(){
                                    return "Mohon maaf item pada service yang anda pilih tidak ditemukan.";
                                }
                            },
                            escapeMarkup: function (markup) {
                                return markup;
                        },
                        ajax: {
                            // url: '/list_transport/find/'+ data[0]['sub_services']['id'],
                            url: '/search_by_customers_with_origin_destinations/find/'+ customers_onload +'/sb/'+ sub_services_id+'/origin/'+ kotaC +'/destination/' + kotaD,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        return {
                                            text: item.itemovdesc,
                                            id: item.id
                                        }
                                })
                            };
                        },
                    cache: true
                }
            });
        });
    });
    // end contrack vendor

    $( document ).ready(function() {
        $('.saved_origin').select2({});
        $('.saved_destination').select2({});
        $('.cusets').select2({placeholder : 'Search here..'});
        $('.units').select2({placeholder : 'Search here..'});
        $('.items_tc').select2({});
        $('.subs').select2({});
        $('.itm').select2({});
        $('.saved_destination').prop("disabled", true);
        $('#items_tc').prop("disabled", true);
        $('#rate').prop("disabled", true);
        $('#eta').prop("disabled", true);
        $('#time_zone').prop("disabled", true);
        $('#etd').prop("disabled", true);
        $('#qty').prop("disabled", true);
        $('#collie').prop("disabled", true);
        $('#volume').prop("disabled", true);
        $('#actual_weight').prop("disabled", true);
        $('#chargeable_weight').prop("disabled", true);
        $('#notes').prop("disabled", true);
        $('.saved_origin').prop("disabled", true);
        $('#sub_servicess').prop("disabled", true);
        $('#moda_x').prop("disabled", true);
        $('.itemsadd').prop("disabled", true);
        $('.customerpics_name').prop("disabled", true);
      });

    $('#customers_name').on('change', function(e){
        $('.saved_origin').prop("disabled", false);

        $('.customerpics_name').prop("disabled", false);
        $('#sub_servicess').prop("disabled", false);
            let customer_id = e.target.value;
            $('#sub_servicess').empty();
            $('#sub_servicess').prop("disabled", true);
            $('.saved_origin').empty();
            $('.saved_destination').prop("disabled", false);
            $('.saved_destination').empty();
            $('#items_tc').empty();

                $('#origin').val('');
                $('#id_origin_city').val('');
                $('#origin_city').empty();
                $('#items_tc').empty();
                $('#items_tcsd').val('');
                $('#rate').val('');
                $('#origin_detail').val('');
                $('#origin_address').val('');
                $('#origin_contact').val('');
                $('#origin_phone').val('');
                $('#destination').val('');
                $('#destination_detail').val('');
                $('#destination_city').empty();
                $('#id_destination_city').val('');
                $('#destination_address').val('');
                $('#destination_contact').val('');
                $('#destination_phone').val('');

            $.get('/search/list_customers_transports/'+ customer_id, function(data){
                
                $('#customerpics_name').empty();
                $.each(data, function(index, Obj){
                    $('#customerpics_name').append($('<option>' ,{
                        value:Obj.id,
                        text:Obj.name
                    }));
                });
            
                //if you make multiple value, you just Include 'select2MultiCheckboxes' on id DOM
                $('.customerpics_name').select2({
                    placeholder: 'Cari...',
                    ajax: {
                        url: '/list_cs_transports/find/'+ customer_id,
                        dataType: 'json',
                        delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        return {
                                            text: item.name,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                        cache: true
                    }
                });

            // event origin
            $('.saved_origin').select2({
                    placeholder: 'Cari...',
                    // allowClear: true,
                    "language": {
                    "noResults": function(){
                        // return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
                        return "Make sure the customer has an address book";
                    }
                },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    ajax: {
                        url: '/search_address_book_with_customers/find/'+ customer_id,
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    // console.log(JSON.stringify(item));
                                    return {
                                        text: item.name + ' - ' +item.address,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true,
                    }
                }).on('change', function(e) {
                     
                $.prototype.enable = function () {
                    $.each(this, function (index, el) {
                        $(el).removeAttr('disabled');
                    });
                }
            //     let el = document.getElementById('idappends');
            // el.setAttribute("class", "");
                nbsp = '&nbsp;';
                // TODO: visible disabled input
                $(".append_this").html(nbsp);
                // nbsp = '&nbsp;';
                // TODO: visible disabled input
                // $(".append_this").html(nbsp);
                // $(".myInputs").enable();
                // TODO: visible disabled input
                $("#origin").enable();
                $("#origin_address").enable();
                $("#pic_phone_origin").enable();
                $("#pic_name_origin").enable();
                $("#origin_city").enable();

                $('.items_tc').prop("disabled", true);
                $('#items_tc').empty();
                $('#rate').val('');
                $('.saved_destination').prop("disabled", false);
                // $('#destination_city_error').show();
                
                // hidden if value is exists
                $('#origin_city_error').hide();
                $('#origin_error').hide();
                $('#origin_detail_error').hide();
                $('#origin_address_error').hide();
                $('#origin_contact_errors').hide();
                $('#origin_phone_errors').hide();
                $('#origin_pic_name_errors').hide();
                $('#pic_phone_origin_errors').hide();

                // $('.sd').empty();
                // $('#destination').val('');
                // $('#destination_detail').val('');
                // $('#destination_city').empty();
                // $('#id_destination_city').val('');
                // $('#pic_name_destination').val('');
                // $('#pic_phone_destination').val('');
                // $('#destination_address').val('');
                // $('#destination_contact').val('');
                // $('#destination_phone').val('');
                // $('#origin_phone').val('');
                // $('#items_tc').prop('disabled', false);
                    $('.saved_destination').select2({
                        placeholder: 'Cari...',
                        // "language": {
                        // "noResults": function(){
                        //          return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
                        //     }
                        // },
                        //     escapeMarkup: function (markup) {
                        //         return markup;
                        // },
                        ajax: {
                            url: '/search_by_value_selected_origin/find/'+$(this).val()+'/customerid/'+ customer_id,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        // $('#origin').val(item.name);
                                        // $('#origin_detail').val(item.details);
                                        $('#origin_city').val(''+item.city_id);
                                        // $('#origin_contact').val(''+item.contact);
                                        return {
                                            text: item.name + ' - ' + item.address,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });
                });

            // event saved_destination
            $('.saved_destination').select2({
                    placeholder: 'Cari...',
                    "language": {
                    "noResults": function(){
                            return "Make sure the customer has an address book";
                            // return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
                        }
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    ajax: {
                        url: '/search_address_book_with_customers/find/'+ customer_id,
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    // console.log(JSON.stringify(item));
                                    return {
                                        text: item.name + ' - ' +item.address,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true,
                    }
                }).on('change', function(e) {
                
                    $.prototype.enable = function () {
                    $.each(this, function (index, el) {
                        $(el).removeAttr('disabled');
                    });
                }
            //     let el = document.getElementById('idappends');
            // el.setAttribute("class", "");
                nbsp = '&nbsp;';
                // TODO: visible disabled input
                $(".append_this").html(nbsp);
                // $(".myInputs").enable();
                // TODO: visible disabled input
                $("#destination").enable();
                $("#destination_address").enable();
                $("#pic_phone_destination").enable();
                $("#pic_name_destination").enable();
                $("#destination_city").enable();

                $('.items_tc').prop("disabled", true);
                $('#items_tc').empty();
                $('#rate').val('');
                $('.saved_origin').prop("disabled", false);
                // $('#origin_city_error').show();
                
                // hidden if value is exists
                $('#destination_city_error').hide();
                $('#destination_error').hide();
                // $('#destination_detail_error').hide();
                $('#destination_address_error').hide();
                // $('#destination_contact_errors').hide();
                // $('#destination_phone_errors').hide();
                $('#destination_pic_name_errors').hide();
                $('#pic_phone_destination_errors').hide();

                // $('.sd').empty();
                // $('#origin').val('');
                // $('#origin_detail').val('');
                // $('#origin_city').empty();
                // $('#id_origin_city').val('');
                // $('#pic_name_origin').val('');
                // $('#pic_phone_origin').val('');
                // $('#origin_address').val('');
                // $('#origin_contact').val('');
                // $('#origin_phone').val('');
                // $('#origin_phone').val('');
                // $('#items_tc').prop('disabled', false);
                    $('.saved_origin').select2({
                        placeholder: 'Cari...',
                        "language": {
                        "noResults": function(){
                                return "Make sure the customer has an address book";
                            // return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
                            }
                        },
                        escapeMarkup: function (markup) {
                            return markup;
                        },
                        ajax: {
                            url: '/search_by_value_selected_destination/find/'+$(this).val()+'/customerid/'+ customer_id,
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        // $('#origin').val(item.name);
                                        // $('#origin_detail').val(item.details);
                                        $('#destination_city').val(''+item.city_id);
                                        // $('#origin_contact').val(''+item.contact);
                                        return {
                                            text: item.name + ' - ' + item.address,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });
                });
                // end event saved_destination
        });
        
            // $('#sub_servicess').empty();
            // $.each(data, function(index, Obj){
                // console.log(Obj.origin);

                // $('#test_sb_service').val('');
                // $('#test_sb_service').val(Obj['sub_services'].id);
                
                // $('#sub_servicess').append($('<option>' ,{
                //     value:Obj.origin,
                //     text:Obj['sub_services'].id +' '+Obj['sub_services'].name
                // }));

                // $('#sub_servicess').select2({
                //     placeholder: 'Cari...',
                //     ajax: {
                //         url: '/load-sub-item-transport-on-load/find/'+ customer_id,
                //         dataType: 'json',
                //         delay: 250,
                //             processResults: function (data) {
                //                 return {
                //                     results: $.map(data, function (item) {
                //                         if(item.customers == null){
                //                             const publish = "Public rate";
                //                             return {
                //                                 text: item.sub_services.name + ' - ' + publish,
                //                                 // id: item.origin
                //                                 id: item.id
                //                             }

                //                         } else {
                //                             const contracts = "Contract rate";
                //                             return {
                //                                 text: item.sub_services.name + ' - ' + contracts,
                //                                 // id: item.origin
                //                                 id: item.id
                //                             }
                //                         }
                //                     })
                //                 };
                //             },
                //             cache: true
                //         }
                //      }).on('change', function (e){
                //     $('#items_tc').prop("disabled", false);
                //         let sub_services_id = e.target.value; 
                //         $('#items_tc').select2({
                //                 placeholder: 'Cari...',
                //                 ajax: {
                //                     // url: '/list_transport/find/'+ data[0]['sub_services']['id'],
                //                     url: '/search_by_customers_with_origin_destinations/find/'+customer_id+'/sb/'+sub_services_id,
                //                     dataType: 'json',
                //                     delay: 250,
                //                     processResults: function (data) {
                //                         return {
                //                             results: $.map(data, function (item) {
                //                                 return {
                //                                     text: item.itemovdesc,
                //                                     id: item.id
                //                                 }
                //                             })
                //                         };
                //                         },
                //                 cache: true
                //             }
                //         });
                //      });

                    // $('.items_tcs').empty();
                        // $('#rate').val('');
                //         $('.items_tcs').select2({
                //             placeholder: 'Cari...',
                //             ajax: {
                //                 url: '/cari_subservice_without_customers/find/'+ customer_id,
                //                 dataType: 'json',
                //                 delay: 250,
                //                     processResults: function (data) {
                //                         return {
                //                             results: $.map(data, function (item) {
                //                                 return {
                //                                     text: item.itemovdesc + ' ' + item.price,
                //                                     id: item.id,
                //                             }
                //                         })
                //                     };
                //                 },
                //             cache: true
                //         }
                // });
            });
        
        // }); 
    // });

    //dynamic select search rate customers->sub_services->item_transport
    // $('#sub_servicess').on('change', function(e){
    //     $('#items_tc').empty();
    //     $('#items_tc').select2({
    //             placeholder: 'Cari...',
    //             ajax: {
    //                 // url: '/list_transport/find/'+ data[0]['sub_services']['id'],
    //                 url: '/search_by_customers_with_origin_destinations/find/'+null+'/sb/'+null,
    //                 dataType: 'json',
    //                 delay: 250,
    //                 processResults: function (data) {
    //                     return {
    //                         results: $.map(data, function (item) {
    //                             return {
    //                                 text: item.itemovdesc,
    //                                 id: item.id
    //                             }
    //                         })
    //                     };
    //                     },
    //             cache: true
    //         }
    //     });
    // });


    $('.onchangeCustomer').on('change', function(e){
        $('#items_tc').prop("disabled", false);
        $('#items_tc').empty();
        $('#rate').val('');
        let tcs = e.target.value;
        $.get('/search_by_items_tcss/find/'+ tcs, function(data){
            $.each(data, function(index, Obj){
                $('.saved_origin').empty();
                $('#origin').val('');
                $('#items_tc').val('');
                $('#items_tcsd').val('');
                $('#rate').val('');
                $('#origin_detail').val('');
                $('#origin_address').val('');
                $('#origin_contact').val('');
                $('#origin_phone').val('');
                $('.saved_origin').select2({
                    placeholder: 'Cari...',
                    "language": {
                    "noResults": function(){
                            return "Make sure the customer has an address book";
                        // return "Make sure the customer has an address book <a href='{{ route('registration.address.book', $some) }}' class='btn btn-default'><i class='icon-plus'></i> Add Address</a>";
                        }
                    },
                    escapeMarkup: function (markup) {
                        return markup;
                    },
                    ajax: {
                        url: '/search_by_origin_item_transport/find/'+ Obj.origin,
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.name + ' - ' +item.details,
                                        id: Obj.origin
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });
                $('#test_sb_service').val(''+Obj.sub_service_id);
            });
        });
    });

            $('.loader_city').select2({
                    placeholder: 'Cari...',
                    ajax: {
                        url: '/load-city/find',
                        dataType: 'json',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item.id +' - '+item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                });

    async function getItemCustomerSync(name, origin, destination) 
    {
        let response = await fetch(`http://your-api.co.id/cari_subservice_without_customers/find/${name}/origin/${origin}/destination/${destination}`);
        let data = await response.json();

        return data;
    }

    $('.saved_destination').on('change', function(e){
        // $('#origin').val('');
        // $('#id_origin_city').val('');
        // $('#origin_city').empty();
        // $('#saved_origin').empty();
        // $('#origin_detail').val('');
        // $('#origin_address').val('');
        // $('#origin_contact').val('');
        // $('#origin_phone').val('');

        $.prototype.enable = function () {
            $.each(this, function (index, el) {
                $(el).removeAttr('disabled');
            });
        }
        // $(".myInputs").enable();
        nbsp = '&nbsp;';
        // TODO: visible disabled input
        $(".append_this").html(nbsp);
        $("#destination").enable();
        $("#destination_address").enable();
        $("#pic_phone_destination").enable();
        $("#pic_name_destination").enable();
        $('#sub_servicess').prop("disabled", false);
        $("#destination_city").enable();
        $('#items_tc').empty();
        $('#sub_servicess').empty();
        // $('#sub_servicess').prop("disabled", false);
        $('#destination_city').empty();
        $('.items_tc').prop("disabled", false);
        $('#rate').val('');
        let saved_destination_id = e.target.value;
        let customer_id = $("#customers_name").val();
        let origin = $("#origin_city").val();
        $.get('/load_address_books_with_customersx/find/'+ saved_destination_id, function(data){
            $.each(data, function(index, Subj){
                $('#destination_city').append($('<option>' ,{
                    value:Subj['citys'].id,
                    text:Subj['citys'].id +' - '+Subj['citys'].name
                }));

                $('#destination').val(''+Subj.name);
                $('#destination_detail').val(Subj.details);
                $('#id_destination_city').val(Subj['citys'].id);
                $('#destination_address').val(''+Subj.address);
                $('#pic_name_destination').val(''+Subj.pic_name_origin);
                $('#pic_phone_destination').val(''+Subj.pic_phone_origin);
                $('#destination_contact').val(''+Subj.contact);
                $('#destination_phone').val(''+Subj.phone);
                // console.log(Subj.pic_name_origin,Subj.pic_phone_origin)
                if( !Subj.pic_name_origin ){
                    $('#destination_pic_name_errors').show();
                } 
                    else {
                        $('#destination_pic_name_errors').hide();
                }

                if( !Subj.pic_phone_origin ){
                    $('#pic_phone_destination_errors').show();
                } 
                    else {
                        $('#pic_phone_destination_errors').hide();
                }

                if( !Subj.address ){
                    $('#destination_address_error').show();
                } 
                    else {
                        $('#destination_address_error').hide();
                }

                if( !Subj.name ){
                    $('#destination_error').show();
                } 
                    else {
                        $('#destination_error').hide();
                }

                if( !Subj['citys'].id ){
                    $('#destination_city_error').show();
                } 
                    else {
                        $('#destination_city_error').hide();
                }
                let destinationsv1 = $("#destination_city").val();

                getItemCustomerSync(customer_id, origin, destinationsv1)
                    .then(saveDestination => 
                        saveDestination.forEach(function(entry) {
                        let arrCustomers = new Array();
                        let arrJSONID = new Array();
                        for (let i = 0; i < saveDestination.length; i++) {
                            arrCustomers.push(saveDestination[i]['customers']);
                        }
                        for (let i = 0; i < arrCustomers.length; i++) {
                            arrJSONID.push(JSON.stringify(arrCustomers[i]));

                        if(arrJSONID == "null"){
                            $('#sub_servicess').select2({
                            placeholder: 'Cari...',
                            "language": {
                            "noResults": function(){
                                    return "Sub service tidak ditemukan";
                                }
                            },
                            escapeMarkup: function (markup) {
                                return markup;
                            },
                                ajax: {
                                    url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ origin + '/destination/' + destinationsv1,
                                    dataType: 'json',
                                    delay: 250,
                                    processResults: function (data) {
                                        return {
                                            results: $.map(data, function (item) {
                                                if(item.customers == null){
                                                    const publish = "PUBLISH";
                                                    return {
                                                        text: item.sub_services.name + ' - ' + publish,
                                                        // id: item.origin
                                                        id: item.id
                                                    }
                                                } else {
                                                    const contracts = "CONTRACT";
                                                    return {
                                                        text: item.sub_services.name + ' - ' + contracts,
                                                        // id: item.origin
                                                        id: item.id
                                                    }
                                                }
                                            })
                                        };
                                    },
                                    cache: true
                                }
                            });

                            break;

                        } else {
                                $('#sub_servicess').select2({
                                placeholder: 'Cari...',
                                    ajax: {
                                        url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ origin + '/destination/' + destinationsv1,
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function (data) {
                                            return {
                                                results: $.map(data, function (item) {
                                                    if(item.customers == null){
                                                        const publish = "PUBLISH";
                                                        return {
                                                            text: item.sub_services.name + ' - ' + publish,
                                                            // id: item.origin
                                                            id: item.id
                                                        }

                                                    } else {
                                                        const contracts = "CONTRACT";
                                                        return {
                                                            text: item.sub_services.name + ' - ' + contracts,
                                                            // id: item.origin
                                                            id: item.id
                                                        }
                                                    }
                                                })
                                            };
                                        },
                                        cache: true
                                    }
                                }
                            ).on('change', function (e){
                                $('#items_tc').prop("disabled", false);
                                let origin = $("#origin_city").val();
                                let destination = $("#destination_city").val();

                                    let sub_services_id = e.target.value; 
                                    // console.log($("#sub_servicess").val())
                                    $('#items_tc').select2({
                                            placeholder: 'Cari...',
                                            "language": {
                                                "noResults": function(){
                                                        return "Mohon maaf item pada service yang anda pilih tidak ditemukan.";
                                                    }
                                                },
                                                escapeMarkup: function (markup) {
                                                    return markup;
                                            },
                                            ajax: {
                                                // url: '/list_transport/find/'+ data[0]['sub_services']['id'],
                                            url: '/search_by_customers_with_origin_destinations/find/'+customer_id+'/sb/'+sub_services_id+'/origin/'+ origin +'/destination/' + destination,
                                            dataType: 'json',
                                            delay: 250,
                                            processResults: function (data) {
                                                return {
                                                        results: $.map(data, function (item) {
                                                            return {
                                                                text: item.itemovdesc,
                                                                id: item.id
                                                        }
                                                    })
                                                };
                                            },
                                            cache: true
                                        }   
                                    });
                                });
                            }
                        }
                    })
                ); 
            });
        });
    });

    $('.saved_origin').on('change', function(e){
        let saved_origin_id = e.target.value;
        $('#origin_city').empty();
        // let el = document.getElementById('idappends');
        // el.setAttribute("class", "append_this");
        nbsp = '&nbsp;';
        $(".append_this").html(nbsp);
        $('#sub_servicess').empty();
        $('#sub_servicess').prop("disabled", false);
        $.get('/load_address_books_with_customers/find/'+ saved_origin_id, function(data){
            $.each(data, function(index, Subj){
                $('#origin').val(''+Subj.name);
                $('#origin_detail').val(Subj.details);
                // $('#origin_city').val(Subj['citys'].name);
                $('#id_origin_city').val(Subj['citys'].id);
                $('#origin_address').val(''+Subj.address);
                $('#origin_contact').val(''+Subj.contact);
                $('#origin_phone').val(''+Subj.phone);
                $('#pic_name_origin').val(''+Subj.pic_name_origin);
                $('#pic_phone_origin').val(''+Subj.pic_phone_origin);
                $('#origin_city').append($('<option>' ,{
                    value:Subj['citys'].id,
                    text:Subj['citys'].id +' - '+Subj['citys'].name
                }));
                if( !Subj.pic_name_origin ){
                    $('#origin_pic_name_errors').show();
                } 
                    else {
                        $('#origin_pic_name_errors').hide();
                }

                if( !Subj.pic_phone_origin ){
                    $('#pic_phone_origin_errors').show();
                } 
                    else {
                        $('#pic_phone_origin_errors').hide();
                }

                if( !Subj.address ){
                    $('#origin_address_error').show();
                } 
                    else {
                        $('#origin_address_error').hide();
                }

                if( !Subj.name ){
                    $('#origin_error').show();
                } 
                    else {
                        $('#origin_error').hide();
                }

                if( !Subj['citys'].id ){
                    $('#origin_error').show();
                } 
                    else {
                        $('#origin_error').hide();
                }
                
                if( !Subj['citys'].id ){
                    $('#origin_city_error').show();
                } 
                    else {
                        $('#origin_city_error').hide();
                }

                let customer_id = $("#customers_name").val();
                let destination = $("#destination_city").val();
                let titikAwal = $('#id_origin_city').val();

                getItemCustomerSync(customer_id, titikAwal, destination)
                    .then(SavedOrigin =>
                    SavedOrigin.forEach(function(entry) {
                        let arrCustomers = new Array();
                        let arrJSONID = new Array();
                        for (let i = 0; i < SavedOrigin.length; i++) {
                            arrCustomers.push(SavedOrigin[i]['customers']);
                        }

                        for (let i = 0; i < arrCustomers.length; i++) {
                            arrJSONID.push(JSON.stringify(arrCustomers[i]));
                            if(arrJSONID == "null"){
                                $('#sub_servicess').select2({
                                placeholder: 'Cari...',
                                "language": {
                                "noResults": function(){
                                        return "Sub services tidak ditemukan";
                                    }
                                },
                                escapeMarkup: function (markup) {
                                    return markup;
                                },
                                ajax: {
                                url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ titikAwal + '/destination/' + destination,
                                dataType: 'json',
                                delay: 250,
                                processResults: function (data) {
                                            return {
                                                results: $.map(data, function (item) {
                                                    if(item.customers == null){
                                                        const publish = "PUBLISH";
                                                                return {
                                                                    text: item.sub_services.name + ' - ' + publish,
                                                                    // id: item.origin
                                                                    id: item.id
                                                                }
                                                        } 
                                                            else {
                                                                const contracts = "CONTRACT";
                                                                return {
                                                                    text: item.sub_services.name + ' - ' + contracts,
                                                                    // id: item.origin
                                                                    id: item.id
                                                                }
                                                        }
                                                    })
                                                };
                                            },
                                                cache: true
                                            }
                                        }
                                    );

                                break;
                                
                            } else {
                                $('#sub_servicess').select2({
                                    placeholder: 'Cari...',
                                    ajax: {
                                        // url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ Subj['citys'].id + '/destination/' + destination, 
                                        url: '/cari_subservice_without_customers/find/'+ customer_id +'/origin/'+ titikAwal + '/destination/' + destination,
                                        dataType: 'json',
                                        delay: 250,
                                            processResults: function (data) {
                                                    return {
                                                        results: $.map(data, function (item) {
                                                            if(item.customers == null){
                                                                const publish = "PUBLISH";
                                                                return {
                                                                    text: item.sub_services.name + ' - ' + publish,
                                                                    // id: item.origin
                                                                    id: item.id
                                                                }

                                                            } else {
                                                                const contracts = "CONTRACT";
                                                                return {
                                                                    text: item.sub_services.name + ' - ' + contracts,
                                                                    // id: item.origin
                                                                    id: item.id
                                                                }
                                                            }
                                                        })
                                                    };
                                                },
                                                cache: true
                                            }
                                        }).on('change', function (e){
                                        let asal = $("#origin_city").val();
                                        let akhirs = $('#destination_city').val();
                                        $('#items_tc').prop("disabled", false);
                                        let sub_services_id = e.target.value; 
                                            $('#items_tc').select2({
                                            placeholder: 'Cari...',
                                            "language": {
                                                "noResults": function(){
                                                        return "Mohon maaf item pada service yang anda pilih tidak ditemukan.";
                                                    }
                                                },
                                                escapeMarkup: function (markup) {
                                                    return markup;
                                            },
                                            ajax: {
                                            url: '/search_by_customers_with_origin_destinations/find/'+customer_id+'/sb/'+sub_services_id+'/origin/'+ asal +'/destination/' + akhirs,
                                            dataType: 'json',
                                            delay: 250,
                                            processResults: function (data) {
                                                return {
                                                    results: $.map(data, function (item) {
                                                        return {
                                                            text: item.itemovdesc,
                                                            id: item.id
                                                        }
                                                    })
                                                };
                                            },
                                                cache: true
                                        }
                                    });
                                });
                            }
                        }
                    })
                );
            });
        });
    });

    $('.items').on('change', function(e){
        let items = e.target.value;
        $.get('/item_price/find/'+ items, function(data){
            $.each(data, function(index, Subj){
                $('#rate').val(''+Subj.price);
            });
        });
    });

    $('.company_braCH').select2({
        placeholder: 'Cari...',
        ajax: {
            url: '/cari_cbrnch',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.branch,
                            id: item.id
                        }
                    })
                };
            },
            cache: false
        }
    });

     $(function() {
        $("#start_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
    });

        $(function() {
            $("#end_date").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });

        // $(document).ready(function () {
        //     $("#rate").keyup(function (data) {
        //         const volume = parseInt(document.getElementById('volume').value);
        //         const rate = parseInt(document.getElementById('rate').value);

        //         let result_rate = parseInt(volume * rate);

        //         result_rate = result_rate.toString().replace(/\$|\,/g, '');

        //         sign = (result_rate == (result_rate = Math.abs(result_rate)));
        //         result_rate = Math.floor(result_rate * 100 + 0.50000000001);
        //         cents = result_rate % 100;
        //         result_rate = Math.floor(result_rate / 100).toString();

        //         if (cents < 10)
        //             cents = "0" + cents;

        //         for (var i = 0; i < Math.floor((result_rate.length - (1 + i)) / 3); i++)
        //         result_rate = result_rate.substring(0, result_rate.length - (4 * i + 3)) + '.' + result_rate.substring(result_rate.length - (4 * i + 3));
                    
        //         if (isNaN(result_rate))

        //             document.getElementById('total_rate').value = (((sign) ? '' : '') + result_rate + '');

        //             if (!isNaN(result_rate))

        //                 document.getElementById('total_rate').value = (((sign) ? '' : '-') + result_rate + '');

        //         });

        // });

        $(document).ready(function () {
            $("#rate").keyup(function (data) {
                const volume = parseInt(document.getElementById('qty').value);
                const rate = parseInt(document.getElementById('rate').value.replace(/[^\de.-]/gi, ""));

                let result_rate = parseInt(rate * volume);

                result_rate = result_rate.toString().replace(/\$|\,/g, '');

                sign = (result_rate == (result_rate = Math.abs(result_rate)));
                result_rate = Math.floor(result_rate * 100 + 0.50000000001);
                cents = result_rate % 100;
                result_rate = Math.floor(result_rate / 100).toString();

                if (cents < 10)
                    cents = "0" + cents;

                for (var i = 0; i < Math.floor((result_rate.length - (1 + i)) / 3); i++)
                result_rate = result_rate.substring(0, result_rate.length - (4 * i + 3)) + '.' + result_rate.substring(result_rate.length - (4 * i + 3));
                        
                if (isNaN(result_rate))
                    document.getElementById('total_rate').value = (((sign) ? '' : '') + result_rate + '');

                    if (!isNaN(result_rate))

                        document.getElementById('total_rate').value = (((sign) ? '' : '-') + result_rate + '');

                });

        });

        $(document).ready(function () {
            $("#qty").keyup(function (data) {
                const volume = parseInt(document.getElementById('qty').value);
                const rate = parseInt(document.getElementById('rate').value);

                let result_rate = parseInt(rate * volume);

                result_rate = result_rate.toString().replace(/\$|\,/g, '');

                sign = (result_rate == (result_rate = Math.abs(result_rate)));
                result_rate = Math.floor(result_rate * 100 + 0.50000000001);
                cents = result_rate % 100;
                result_rate = Math.floor(result_rate / 100).toString();

                if (cents < 10)
                    cents = "0" + cents;

                for (var i = 0; i < Math.floor((result_rate.length - (1 + i)) / 3); i++)
                result_rate = result_rate.substring(0, result_rate.length - (4 * i + 3)) + '.' + result_rate.substring(result_rate.length - (4 * i + 3));
                        
                if (isNaN(result_rate))
                    document.getElementById('total_rate').value = (((sign) ? '' : '') + result_rate + '');

                    if (!isNaN(result_rate))

                        document.getElementById('total_rate').value = (((sign) ? '' : '-') + result_rate + '');

                });

        });

      $(document).ready(function () {
        $("#rate").keypress(function (data) {
            if (data.which != 8 && data.which != 0 && (data.which < 48 || data.which > 57)) {
                $("#rate").html('errors')
                return false;
            }
        });
    });
    
    $('.CustomerTaxTypes').select2({
        placeholder: 'Cari...',
        ajax: {
        url: '/type-pajak',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
         return {
           results:  $.map(data, function (item) {
             return {
               text: item.name,
               id: item.id
             }
           })
         };
        },
        cache: true
        }
     });


    // $('.items_tc').select2({
    //     placeholder: 'Cari...',
    //     ajax: {
    //         url: '/load_item_transport/find',
    //         dataType: 'json',
    //         delay: 250,
    //         processResults: function (data) {
    //             return {
    //                 results: $.map(data, function (item) {
    //                     // $('#origin').val(item.name);
    //                     // $('#origin_detail').val(item.details);
    //                     // $('#origin_address').val(''+item.address);
    //                     // $('#origin_contact').val(''+item.contact);
    //                     return {
    //                         text: item.itemovdesc,
    //                         id: item.id
    //                     }
    //                 })
    //             };
    //         },
    //         cache: true
    //     }
    // });

    
    // $('.saved_origin').select2({
    //     placeholder: 'Cari...',
    //     ajax: {
    //         url: '/load_address_book/find',
    //         dataType: 'json',
    //         delay: 250,
    //         processResults: function (data) {
    //             return {
    //                 results: $.map(data, function (item) {
    //                     // $('#origin').val(item.name);
    //                     // $('#origin_detail').val(item.details);
    //                     // $('#origin_address').val(''+item.address);
    //                     // $('#origin_contact').val(''+item.contact);
    //                     return {
    //                         text: item.name + ' - ' +item.details,
    //                         id: item.id
    //                     }
    //                 })
    //             };
    //         },
    //         cache: true
    //     }
    // });

 

    //    $('.saved_destination').select2({
    //     placeholder: 'Cari...',
    //     ajax: {
    //         url: '/load_address_book/find',
    //         dataType: 'json',
    //         delay: 250,
    //         processResults: function (data) {
    //             return {
    //                 results: $.map(data, function (item) {
    //                     // $('#origin').val(item.name);
    //                     // $('#origin_detail').val(item.details);
    //                     // $('#origin_address').val(''+item.address);
    //                     // $('#origin_contact').val(''+item.contact);
    //                     return {
    //                         text: item.name + ' - ' +item.details,
    //                         id: item.id
    //                     }
    //                 })
    //             };
    //         },
    //         cache: true
    //     }
    // });

    //  $('.saved_destination').on('change', function(e){
    //     let saved_destination_id = e.target.value;
    //     $.get('/load_address_book/find/'+ saved_destination_id, function(data){
    //         $.each(data, function(index, Subj){
    //             $('#destination').val(''+Subj.name);
    //             $('#destination_detail').val(Subj.details);
    //             $('#destination_address').val(''+Subj.address);
    //             $('#destination_contact').val(''+Subj.contact);
    //             $('#destination_phone').val(''+Subj.phone);
    //         });
    //     });
    // });