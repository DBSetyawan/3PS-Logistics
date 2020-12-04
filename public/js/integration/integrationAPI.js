$("#authorized").click(function(event) {
    event.preventDefault()
    let client_id = document.getElementById('client_id').value;
        let response_type = document.getElementById('response_type').value;
        let redirect_uri = document.getElementById('redirect_url').value;
        let scope = document.getElementById('scope').value;
        return new Promise((resolve, reject) => {

            Authorization(
                client_id, response_type, redirect_uri, scope).then((result) => {
                    return result

            });
        });
    });

 async function Authorization(client_id, response_type, redirect_uri, scope
    ) {
                  
        const reqauth = {
            response_type:response_type,
            client_id:client_id,
            redirect_uri:redirect_uri,
            scope: scope,
        }

              const ApiAuthotized = "{{ route('api.accurate.authorize') }}";
                
            const conf = {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json;charset=utf-8'
                        },
                    body: JSON.stringify(reqauth)
                }

              try {
                    
                    const fetchResponse = await fetch(`${ApiAuthotized}`, conf);
                    const data = await fetchResponse.json();

                    return data;
                    
            } catch (error) {

                return error

            }    

        }
         /** 
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
    */

    function ajax(url) {
        return new Promise(function(resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.onload = function() {
            resolve(this.responseText);
            };
            xhr.onerror = reject;
            xhr.open('GET', url);
            xhr.send();
        });
    }

$(document).ready(function(){
    const branch_id = "{{ $some }}";

    $('input[type="checkbox"]').click(function(e){
        if($(this).prop("checked") == true){
            let izzy = [];
            izzy.push($(this).val());
            $.ajax({
                type: "get",
                url: `{{ url('/dashboard/find-branch-with-branch/branch-id/${branch_id}/API-activation') }}`,
                dataType: "json",
                data: {
                    izzy:izzy
                },
                    success: function (data) {
                    let arrpush = new Array();

                    for (let index = 0; index < data.length; index++) {
                        arrpush.push(data[index])
                        
                    }

                    let fetch_json = arrpush[0]['check_is'];
                    const data_izzy = fetch_json.replace("api_izzy","Izzy Transports");
                    const data_accurate = fetch_json.replace("api_accurate","Accurate Accounting System");
                    const toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 6000
                        });

                        if(data_izzy == "Izzy Transports"){
                            toast({

                                  title: `<div><i class="fa fa-circle text-success"></i></div>&nbsp;Anda terhubung dengan API ${data_izzy} !`

                            })  

                        } 
                            else if(data_accurate == "Accurate Accounting System"){

                                toast({

                                      title: `<div><i class="fa fa-circle text-success"></i></div>&nbsp;Anda terhubung dengan API ${data_accurate} !`


                                })

                        }

                        setTimeout(() => {

                            let isAdmin = "{{ $auths }}"; //assignwithroles

                                    if (isAdmin == '3PL[ACCOUNTING][TC]') {
                                    let loadUrl = 'http://devyour-api.co.id/transport-order-accounting';
                                        // console.log('ACCOUNTING')
                                        window.location.reload();
                                        let hWndA = window.open(loadUrl),
                                        Me = window.self;
                                        Me.onunload = function()
                                        { 
                                            hWndA.location.reload(); 
                                        }
                                        
                                    } 
                                    
                                    if (isAdmin == '3PL[OPRASONAL][TC]') {
                                        let loadUrl = 'http://devyour-api.co.id/transport-list';
                                        // console.log('ACCOUNTING')
                                        window.location.reload();
                                        let hWndA = window.open(loadUrl),
                                        Me = window.self;
                                        Me.onunload = function()
                                        { 
                                            hWndA.location.reload(); 
                                        }

                                    }

                                    if (isAdmin == '3PL[OPRASONAL][WHS]') {
                                        let loadUrl = 'http://devyour-api.co.id/transport-list';
                                        // console.log('ACCOUNTING')
                                        window.location.reload();
                                        let hWndA = window.open(loadUrl),
                                        Me = window.self;
                                        Me.onunload = function()
                                        { 
                                            hWndA.location.reload(); 
                                        }

                                    }

                        me = window.self;
                        me.location.reload();
                                 
                    }, 3100);

                },
                    error: function(data){
                        toast({

                            title: `<div><i class="fa fa-circle" style="color:red"></i></div>&nbsp;Unknown API error!`

                    })

                }

            });

        }

            else if($(this).prop("checked") == false){
                let accurate = [];

                accurate.push($(this).val());

                    $.ajax({
                        type: "get",
                        url: `{{ url('/dashboard/find-branch-with-branch/branch-id/${branch_id}/API-unactive') }}`,
                        dataType: "json",
                        data: {
                            accurate:accurate,
                        },

                            success: function (datax) {

                                let fetch_uncheckjson = datax['check_is'];
                                const datauncheck = fetch_uncheckjson.replace("api_izzy","Izzy Transports");
                                const data_accurate = fetch_uncheckjson.replace("api_accurate","Accurate Accounting System");

                                const toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 6000
                            });

                            if(datauncheck == "Izzy Transports"){

                                toast({

                                    title: `<div><i class="fa fa-circle" style="color:red"></i></div>&nbsp;Anda telah terputus dengan koneksi ${datauncheck} !`


                                })  

                            } 
                                else if(data_accurate == "Accurate Accounting System")
                                
                                    {

                                        toast({

                                        title: `<div><i class="fa fa-circle" style="color:red"></i></div>&nbsp;Anda telah terputus dengan koneksi ${data_accurate} !`



                                        })

                                    }
                        
                                setTimeout(() => {

                                        let isAdmin = "{{ $auths }}"; //assignwithroles

                                        if (isAdmin == '3PL[ACCOUNTING][TC]') {
                                            let loadUrl = 'http://devyour-api.co.id/transport-order-accounting';
                                            // console.log('ACCOUNTING')
                                            window.location.reload();
                                            let hWndA = window.open(loadUrl),
                                            Me = window.self;
                                            Me.onunload = function()
                                            { 
                                                hWndA.location.reload(); 
                                            }
                                        
                                        } 
                                    
                                    if (isAdmin == '3PL[OPRASONAL][TC]') {
                                        let loadUrl = 'http://devyour-api.co.id/transport-list';
                                        // console.log('ACCOUNTING')
                                        window.location.reload();
                                        let hWndA = window.open(loadUrl),
                                        Me = window.self;
                                        Me.onunload = function()
                                        { 
                                            hWndA.location.reload(); 
                                        }

                                    }

                                    if (isAdmin == '3PL[OPRASONAL][WHS]') {
                                        let loadUrl = 'http://devyour-api.co.id/transport-list';
                                        // console.log('ACCOUNTING')
                                        window.location.reload();
                                        let hWndA = window.open(loadUrl),
                                        Me = window.self;
                                        Me.onunload = function()
                                        { 
                                            hWndA.location.reload(); 
                                        }

                                    }

                                me = window.self;
                                me.location.reload();

                            }, 3100);

                        },
                            error: function(data){

                                toast({

                                    title: `<div><i class="fa fa-circle" style="color:red"></i></div>&nbsp;Unknown API error!`

                        })

                    }

                });

            }

        });

    });