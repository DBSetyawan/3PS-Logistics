// load-ready
// origin
let origin_of_error = $('#origin').val();
let origin_address_of_error = $('#origin_address').val();
let origin_phone_of_error = $('#pic_phone_origin').val();
let origin_pic_name_of_error = $('#pic_name_origin').val();

// destination
let destinations = $('#destination').val();
let destination_addresss = $('#destination_address').val();
let pic_name_destinations = $('#pic_name_destination').val();
let pic_phone_destinations = $('#pic_phone_destination').val();

if( !origin_of_error || !origin_address_of_error || !origin_phone_of_error || !origin_pic_name_of_error){
    $('#origin_error').show();
    $('#origin_address_error').show();
    $('#origin_pic_name_errors').show();
    $('#pic_phone_origin_errors').show();
    }
        else if(!destinations || !destination_addresss || !pic_name_destinations || !pic_phone_destinations) {
            $('#destination_error').show();
            $('#destination_address_error').show();
            $('#destination_pic_name_errors').show();
            $('#pic_phone_destination_errors').show();
        }
            else 
                    {
                        $('#origin_error').hide();
                        $('#origin_address_error').hide();
                        $('#origin_pic_name_errors').hide();
                        $('#pic_phone_origin_errors').hide();

                        $('#destination_error').hide();
                        $('#destination_address_error').hide();
                        $('#destination_pic_name_errors').hide();
                        $('#pic_phone_destination_errors').hide();
    }