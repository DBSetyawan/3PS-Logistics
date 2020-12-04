<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{csrf_token()}}">
<title>Login - {{ config('app.name') }}</title>
<link href=" {{ asset('js/sweetalert2.css') }}" rel="stylesheet">
<script src="{{ asset('js/sweetalert2.js') }}"></script>
<link href=" {{ mix('css/latest-tailwind.css') }}" rel="stylesheet">
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('js/new-login.js') }}"></script>
<link rel='manifest' href=" {{ asset('js/pwabuilder/manifest.json') }}">
<link rel="shortcut icon" href="{{ asset('img/logo.ico') }}" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<script
  type="module"
>
import 'https://cdn.jsdelivr.net/npm/@pwabuilder/pwaupdate';

const el = document.createElement('pwa-update');
document.body.appendChild(el);

</script>
</head>

    <body class="bg-grey-lighter h-screen font-sans" style="background: linear-gradient(90deg, #d53369 0%, #daae51 100%);">
        <div id="app">
			<div class="container mx-auto">
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
			  </div>
		</div>
			<form class="rounded px-2 pt-6 pb-8 mb-4">
				<style>
					.lfoot{
						display: block;
    margin: 0 auto;
    width: 100%;
    max-width: 430px;
    padding: 26.66667px 0;
    text-align: center;
    background: -webkit-linear-gradient(90deg,rgba(255,255,255,0) 0,rgba(255,255,255,0.2) 50%,rgba(255,255,255,0) 100%);
    background: linear-gradient(90deg,rgba(255,255,255,0) 0,rgba(255,255,255,0.2) 50%,rgba(255,255,255,0) 100%);
    background-size: 100% 1px;
    background-repeat: no-repeat;
					}
					.input {
						transition: border 0.2s ease-in-out;
						min-width: 280px
					}
				
					.input:focus+.label,
					.input:active+.label,
					.input.filled+.label {
						font-size: .75rem;
						transition: all 0.2s ease-out;
						top: -0.1rem;
						color: #667eea;
					}
				
					.label {
						transition: all 0.2s ease-out;
						top: 0.4rem;
						left: 0;
					}
				</style>
				<div style="font-family:Quicksand" class="container mx-auto h-full flex absolute justify-center items-center mb-0 inset-0">
					{{--  <div class="grid grid-cols-3 gap-4">grid grid-cols-6 gap-4  --}}
						<div class="grid grid-cols-6 gap-4">
						<div class="col-span-3">
							<div class="bg-teal-lightest border-t-4 border-teal rounded-b text-teal-darkest px-4 py-3 shadow-md my-2" role="alert">
								<div class="flex">
								  <svg class="h-6 w-6 text-teal mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg>
								  <div>
									<p class="font-bold">3PS live</p>
									<p class="text-sm">3PL & 3PE company, 3PS version production system.</p>
								  </div>
								</div>
							  </div>
								<span id="alert-success-auth" class="hidden">
									<div class="container p-2 text-center py-4 lg:px-15 bg-red-700 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex hidden">
										<span class="flex rounded-full bg-red-600 uppercase px-2 py-1 text-xs font-bold mr-3">Failed</span>
										<span class="font-semibold mr-2 text-left flex-auto">Authentication Failed</span>
										<svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
									  </div>
								</span>
								<span id="alert-success-auth-verified" class="hidden">
									<div class="container p-2 text-center py-4 lg:px-15 bg-green-900 items-center text-green-800 leading-none lg:rounded-full flex lg:inline-flex hidden">
										<span class="flex rounded-full bg-green-700 uppercase px-2 py-1 text-xs text-white font-bold mr-3">Success</span>
										<span class="font-semibold mr-2 text-left text-white flex-auto">Authentication Successfully, Please wait...</span>
										<svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
									  </div>
								</span>
								  &nbsp;
								<div class="border-teal p-3 border-t-12 bg-gray-100 mb-24 rounded-lg shadow-lg">
									<div class="md:flex">
										<div class="md:flex-no-shrink md:w-10">
											<img class="rounded" src="https://s3-ap-southeast-1.amazonaws.com/magazine.job-like.com/magazine/wp-content/uploads/2017/08/21170129/3356-3.png"> <br/>
										</div>
											<div class="md:flex-no-shrink md:w-10">
											<img class="rounded" src="https://i.pinimg.com/favicons/50d5f2661efce8535acc7a5c3b822160e39502fc6b524615b042298b.png?13caba22ff9a93a6fbd61033dd089fa4">
										</div>
									</div>
									
								{{-- <h1 class="text-4xl font-black mb-4"><font face='Fira Code' style='font-size:25px;color:black'>[3PS] Login</font></h1> --}}
								@if ($errors->has('email'))
									<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" id="att" role="alert">
										<strong class="font-bold">terjadi Kesalahan!</strong><br/>
										<span class="block sm:inline">{{ $errors->first('email') }}</span>
										<span class="absolute top-0 bottom-0 right-0 px-4 py-3">
										  <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title></svg>
										</span>
									</div>
									<br/>
								@endif
								<div class="mb-2 relative">
									<input class="input border border-gray-400 appearance-none rounded w-full px-3 py-3 pt-5 pb-2 focus focus:border-indigo-600 focus:outline-none active:outline-none active:border-indigo-600" id="email" name="email" type="text" autofocus>
									<label for="email" class="label absolute mb-0 -mt-2 pt-4 pl-3 leading-tighter text-gray-400 text-base mt-2 cursor-text">Email Address</label>
								</div>
								<div class="mb-2 relative">
									<input class="input border border-gray-400 appearance-none rounded w-full px-3 py-3 pt-5 pb-2 focus focus:border-indigo-600 focus:outline-none active:outline-none active:border-indigo-600" id="password" name="password" type="password" autofocus>
									<label for="password" class="label absolute mb-0 -mt-2 pt-4 pl-3 leading-tighter text-gray-400 text-base mt-2 cursor-text">Password</label>
								</div>
								<a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ url('password/reset') }}">
									<div class="bg-gray-light border-l-4 border-pink-800 text-dark p-6" role="alert">
										<p class="font-bold"></p>
										<p style='font-size:15px;color:black'>Anda bisa reset password disini.</p>
									  </div> 
								</a>
								<div class="text-right">
								<button class="bg-indigo-600 hover:bg-blue-dark text-white font-bold py-3 px-6 rounded" id="login">Masuk</button>
								</div>
							</form>
								{{--  https://tailwindcss.com/docs/grid-column  --}}
								<div class="col-span-2"></div>
								<div class="col-span-1"></div>
								<div class="col-start-1 col-end-7">
									<div class="divide-y sm:divide-y-2 md:divide-y-4 lg:divide-y-8 xl:divide-y-0 divide-gray-400">
										{{-- <div class="text-center py-2">Anda bisa mengakses status pengiriman disini</div> --}}
										{{-- <div class="text-center py-2">	<a type="button" id="types" class="transition delay-300 duration-300 ease-in-out cursor-pointer bg-olive-activew-full bg-olive-active hover:bg-green-gradient text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
											Tracking Shipment --}}
											<tr>
												<td style="padding: 24px 0; background-color: #e5e7eb;">
												  <h1 style="margin: 0; font-size: 36px; font-family: -apple-system, 'Segoe UI', sans-serif; color: #000000;"></h1>
												  <p style="margin: 0; font-size: 16px; line-height: 24px; color: #374151;"><i class="fas fa-key"></i> Authentication required</p>
												</td>
											  </tr>
											{{-- <div class="text-center py-2">@feedback <a href="mail:to" class="hre"></a>/div> --}}
										</a> </div>
									</div>
								</div>
								<div class="col-span-2"></div>
							</div>
						</div>
					</div>
				</div>
			<div class="relative -mt-12 lg:-mt-24">
				<svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				<g transform="translate(-2.000000, 20.000000)" fill="#FFFFFF" fill-rule="nonzero">
				<path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
				<path d="M100,104.708498 C277.413333,90.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z" opacity="0.100000001"></path>
				<path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" id="Path-4" opacity="0.200000003"></path>
				</g>
				<g transform="translate(-4.000000, 76.000000)" fill="#gray" fill-rule="nonzero">
				<path d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z"></path>
				</g>
				</g>
				</svg>
			</div>
			<script>
			</script>
	</body>
</html>