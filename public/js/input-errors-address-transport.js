// origins
const origin = document.getElementById('origin')

    origin.addEventListener('input', evt => {
    const value = origin.value

        if (!value) {
            origin.dataset.state = ''
            $("#origin_error").show();
            return true;
        } else
                {
            $("#origin_error").hide();
            return false;
        }

})


const destination = document.getElementById('destination')

destination.addEventListener('input', evt => {
const value = destination.value

    if (!value) {
        destination.dataset.state = ''
        $("#destination_error").show();
        return true;
    } else
            {
        $("#destination_error").hide();
        return false;
    }

})

// const origin_detail = document.getElementById('origin_detail')

// origin_detail.addEventListener('input', evt => {
// const value = origin_detail.value

//     if (!value) {
//         origin_detail.dataset.state = ''
//         $("#origin_detail_error").show();
//         return true;
//     } else
//             {
//         $("#origin_detail_error").hide();
//         return false;
//     }

// })


// const destination_detail = document.getElementById('destination_detail')

// destination_detail.addEventListener('input', evt => {
// const value = destination_detail.value

//     if (!value) {
//         destination_detail.dataset.state = ''
//         $("#destination_detail_error").show();
//         return true;
//     } else
//             {
//         $("#destination_detail_error").hide();
//         return false;
//     }

// })

const origin_address = document.getElementById('origin_address')

origin_address.addEventListener('input', evt => {
const value = origin_address.value

    if (!value) {
        origin_address.dataset.state = ''
        $("#origin_address_error").show();
        return true;
    } else
            {
        $("#origin_address_error").hide();
        return false;
    }

})

const regions_errors = document.getElementById('regions')

regions.addEventListener('input', evt => {
const value = regions.value

    if (!value) {
        regions.dataset.state = ''
        $("#regions_errors").show();
        return true;
    } else
            {
        $("#regions_errors").hide();
        return false;
    }

})

const destination_address = document.getElementById('destination_address')

destination_address.addEventListener('input', evt => {
const value = destination_address.value

    if (!value) {
        destination_address.dataset.state = ''
        $("#destination_address_error").show();
        return true;
    } else
            {
        $("#destination_address_error").hide();
        return false;
    }

})

// const origin_contract = document.getElementById('origin_contact')

// origin_contract.addEventListener('input', evt => {
// const value = origin_contract.value

//     if (!value) {
//         origin_contract.dataset.state = ''
//         $("#origin_contact_errors").show();
//         return true;
//     } else
//             {
//         $("#origin_contact_errors").hide();
//         return false;
//     }

// })

// const destination_contact = document.getElementById('destination_contact')

// destination_contact.addEventListener('input', evt => {
// const value = destination_contact.value

//     if (!value) {
//         destination_contact.dataset.state = ''
//         $("#destination_contact_errors").show();
//         return true;
//     } else
//             {
//         $("#destination_contact_errors").hide();
//         return false;
//     }

// })

// const origin_phone = document.getElementById('origin_phone')

// origin_phone.addEventListener('input', evt => {
// const value = origin_phone.value

//     if (!value) {
//         origin_phone.dataset.state = ''
//         $("#origin_phone_errors").show();
//         return true;
//     } else
//             {
//         $("#origin_phone_errors").hide();
//         return false;
//     }

// })

// const destination_phone = document.getElementById('destination_phone')

// destination_phone.addEventListener('input', evt => {
// const value = destination_phone.value

//     if (!value) {
//         destination_phone.dataset.state = ''
//         $("#destination_phone_errors").show();
//         return true;
//     } else
//             {
//         $("#destination_phone_errors").hide();
//         return false;
//     }

// })

const origin_pic_name = document.getElementById('pic_name_origin')

origin_pic_name.addEventListener('input', evt => {
const value = origin_pic_name.value

    if (!value) {
        origin_pic_name.dataset.state = ''
        $("#origin_pic_name_errors").show();
        return true;
    } else
            {
        $("#origin_pic_name_errors").hide();
        return false;
    }

})

const destination_pic_name = document.getElementById('pic_name_destination')

destination_pic_name.addEventListener('input', evt => {
const value = destination_pic_name.value

    if (!value) {
        destination_pic_name.dataset.state = ''
        $("#destination_pic_name_errors").show();
        return true;
    } else
            {
        $("#destination_pic_name_errors").hide();
        return false;
    }

})



const origin_pic_phone = document.getElementById('pic_phone_origin')

origin_pic_phone.addEventListener('input', evt => {
const value = origin_pic_phone.value

    if (!value) {
        origin_pic_phone.dataset.state = ''
        $("#pic_phone_origin_errors").show();
        return true;
    } else
            {
        $("#pic_phone_origin_errors").hide();
        return false;
    }

})

const destination_pic_phone = document.getElementById('pic_phone_destination')

destination_pic_phone.addEventListener('input', evt => {
const value = destination_pic_phone.value

    if (!value) {
        destination_pic_phone.dataset.state = ''
        $("#pic_phone_destination_errors").show();
        return true;
    } else
            {
        $("#pic_phone_destination_errors").hide();
        return false;
    }

})

$('.customer_names').on('change', function(e){
    let tcs = e.target.value;
        if(tcs > 0){
            $("#customers_errors").hide();
            return true;
        }
    return;
});

$('.destinationloaders').on('change', function(e){
    let tcs = e.target.value;
        if(tcs > 0){
            $("#destination_city_error").hide();
            return true;
        }
    return;
});

$('.originloaders').on('change', function(e){
    let tcs = e.target.value;
        if(tcs > 0){
            $("#origin_city_error").hide();
            return true;
        }
    return;
});