// origins
const origins = document.getElementById('project_name')

    origins.addEventListener('keyup', evt => {
    const values = origins.value

        if (!values) {
            origins.dataset.state = ''
            $(".Customer").show();
            return true;
        } else
                {
            $(".Customer").hide();
            return false;
        }

})

const emails = document.getElementById('email')

    emails.addEventListener('keyup', evt => {
    const values = emails.value

        if (!values) {
            emails.dataset.state = ''
            $(".Emails").show();
            return true;
        } else
                {
            $(".Emails").hide();
            return false;
        }

})

const noPajak = document.getElementById('tax_no')

    noPajak.addEventListener('keyup', evt => {
    const value = noPajak.value

        if (!value) {
            noPajak.dataset.state = ''
            $(".npwp").show();
            return true;
        } else
                {
            $(".npwp").hide();
            return false;
        }

})

const alamatPajak = document.getElementById('tax_address')

    alamatPajak.addEventListener('keyup', evt => {
    const value = alamatPajak.value

        if (!value) {
            alamatPajak.dataset.state = ''
            $(".tax_alamatss").show();
            return true;
        } else
                {
            $(".tax_alamatss").hide();
            return false;
        }

})

const alamatpenagihan = document.getElementById('alamatpenagihan')

    alamatpenagihan.addEventListener('keyup', evt => {
    const value = alamatpenagihan.value

        if (!value) {
            alamatpenagihan.dataset.state = ''
            $(".PNGHN_alamatss").show();
            return true;
        } else
                {
            $(".PNGHN_alamatss").hide();
            return false;
        }

})

const kodepos = document.getElementById('ops_kodepos')

    kodepos.addEventListener('keyup', evt => {
    const value = kodepos.value

        if (!value) {
            kodepos.dataset.state = ''
            $(".ops_kodeposss").show();
            return true;
        } else
                {
            $(".ops_kodeposss").hide();
            return false;
        }

})

const bank_name = document.getElementById('bank_name')

    bank_name.addEventListener('keyup', evt => {
    const value = bank_name.value

        if (!value) {
            bank_name.dataset.state = ''
            $(".nama_bankss").show();
            return true;
        } else
                {
            $(".nama_bankss").hide();
            return false;
        }

})

const no_rek = document.getElementById('no_rek')

    no_rek.addEventListener('keyup', evt => {
    const value = no_rek.value

        if (!value) {
            no_rek.dataset.state = ''
            $(".nomor_rekeningss").show();
            return true;
        } else
                {
            $(".nomor_rekeningss").hide();
            return false;
        }

})

const an_bank = document.getElementById('an_bank')

    an_bank.addEventListener('keyup', evt => {
    const value = an_bank.value

        if (!value) {
            an_bank.dataset.state = ''
            $(".atas_nama_bankss").show();
            return true;
        } else
                {
            $(".atas_nama_bankss").hide();
            return false;
        }

})

const term_of_payment = document.getElementById('term_of_payment')

    term_of_payment.addEventListener('keyup', evt => {
    const value = term_of_payment.value

        if (!value) {
            term_of_payment.dataset.state = ''
            $(".kebijakan_pembayaranss").show();
            return true;
        } else
                {
            $(".kebijakan_pembayaranss").hide();
            return false;
        }

})

const sinces = document.getElementById('since')

    sinces.addEventListener('click', evt => {
        if (!evt.target.value) {
            sinces.dataset.state = ''
            $(".Sinces").show();
            return true;
        }

})

const address = document.getElementById('address')

    address.addEventListener('keyup', evt => {
    const value = address.value

        if (!value) {
            address.dataset.state = ''
            $(".alamatops").show();
            return true;
        } else
                {
            $(".alamatops").hide();
            return false;
        }

})

$('#type_of_business').on('change', function(e){
    let tcs = e.target.value;
        if(tcs > 0){
            $(".tipe_bisnisss").hide();
            return true;
        }
    return;
});

$('#tax_city').on('change', function(e){
    let tcs = e.target.value;
        if(tcs > 0){
            $(".tax_citys").hide();
            return true;
        }
    return;
});

$('#CustomerTaxType').on('change', function(e){
    let taxtype = e.target.value;
        if(!!taxtype){
            $(".CustomertaxTypess").hide();
            return true;
        }
    return;
});

$('#penagihanKOTA').on('change', function(e){
    let tcs = e.target.value;
        if(tcs > 0){
            $(".PNGHctyss").hide();
            return true;
        }
    return;
});

$('#penagihanPRV').on('change', function(e){
    let tcs = e.target.value;
        if(tcs > 0){
            $(".pengihanPRVss").hide();
            return true;
        }
    return;
});

$('#provinceops').on('change', function(e){
    let tcs = e.target.value;
        if(tcs > 0){
            $(".provinceopsss").hide();
            return true;
        }
    return;
});

$('#kota').on('change', function(e){
    let tcs = e.target.value;
        if(tcs > 0){
            $(".ops_kotass").hide();
            return true;
        }
    return;
});