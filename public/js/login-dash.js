var toggleInputContainer = function (input) {
    if (input.value != "") {
        input.classList.add('filled');
    } else {
        input.classList.remove('filled');
    }
}

var labels = document.querySelectorAll('.label');
for (var i = 0; i < labels.length; i++) {
    labels[i].addEventListener('click', function () {
        this.previousElementSibling.focus();
    });
}

window.addEventListener("load", function () {
    var inputs = document.getElementsByClassName("input");
    for (var i = 0; i < inputs.length; i++) {
    
        inputs[i].addEventListener('keyup', function () {
            toggleInputContainer(this);
        });
        toggleInputContainer(inputs[i]);
    }
});

$('#att').delay(10000).fadeOut('slow');

async function Logged(apiloggedinUser) {
const awaitlogin = await fetch(apiloggedinUser, {
        method: 'POST',
        cache: 'no-cache',
        credentials: 'same-origin',
        redirect: 'follow',
        referrer: 'no-referrer',
        body: JSON.stringify(dataLogin),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json'
        }
    }
);
    
const auth = await awaitlogin.json();

return auth;
}
async function logInUseRs() {

    try {

        const apiLoginUser = "http://devyour-api.co.id/login";
        let email = $("#email").val();
        let password = $("#password").val();

            const dataLogin = { 

                    email: email,
                    password: password

                };

                    const configuration = {
                        method: 'POST',
                        cache: 'no-cache',
                        credentials: 'same-origin',
                        redirect: 'follow',
                        referrer: 'no-referrer',
                        body: JSON.stringify(dataLogin),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json'
                        }
                    }

        const redirect = await fetch(`${apiLoginUser}`, configuration);
        
    const datajsonuser = await redirect.json();
    let VendorsPromise = new Promise((resolve, reject) => {
            // Swal.queue(
            // 	[
            // 		{
            // 			title: 'Authentication',
            // 			icon: 'success',
            // 			html:'<font face="Fira Code" style="font-size:12px;color:black">Authentication successfully</font>',
            // 			showLoaderOnConfirm: true,
            // 			confirmButtonText: 'Okay',
            // 			preConfirm: () => {
                            document.getElementById('alert-success-auth-verified').style.display ='inline',
                            $('#alert-success-auth-verified').delay(6660).fadeOut('slow'),
                            setTimeout(() => resolve(
                                window.location.reload(true)
                            ), 7000)
                            $("#login").text("Masuk");
            // 			}
            // 		}
            // 	]
            // )
        }
    );
} catch (error) {
    $("#login").text("Masuk");
    $("#login").prop("disabled", false);
    const css = document.getElementById('alert-success-auth').style.display ='inline';
    $('#alert-success-auth').delay(10000).fadeOut('slow');

    // css.classList.toggle("hidden")

        // Swal.fire({
        // 	icon: 'error',
        // 	title: 'Authentication failed!',
        // 	text: 'Account not found!',
        // 	footer: '<a href>Try again to Sign in?</a>'
        // })
        // const ds = document.getElementById(').style.display='hidden'

    }
}
$(function(){
    $('#login').click(function (e) {
        $("#login").text("Verifying...");
        $("#login").prop("disabled", true);
        e.preventDefault();
        return new Promise((resolve, reject) => {
                setTimeout(() => resolve(logInUseRs()), 3500)
            }
        );
    });
});

$(function(){
    $('#types').click(function (e) {
        $("#types").text("Silahkan tunggu anda sedang dialihkan...");
        e.preventDefault();
        return new Promise((resolve, reject) => {
                setTimeout(() => resolve(window.location.href = "http://devyour-api.co.id/tracking/shipment"), 4000)
            }
        );
    });
});