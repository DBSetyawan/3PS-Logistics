<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{csrf_token()}}">
	<link rel="shortcut icon" href="{{ asset('img/favicontracking.png') }}">
	<title>Live Tracking - {{ config('app.name') }}</title>
	<link href=" {{ asset('css/dekstop3854954/defer-developments.css') }}" rel="stylesheet">
	<link href=" {{ mix('css/app.css') }}" rel="stylesheet">
</head>
<style>
.empty-state {
    width: 96%;
    position: relative;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    border: 2px dashed #eee;
    text-align: center;
    padding: 10px 20px;
    margin: 10px 0
}
</style>
<body class="bg-grey-lighter g-gray-200 h-screen font-sans overflow-y-scroll">
	<div class="bg-gray-100 font-sans w-full min-h-screen m-0">
		<div class="bg-white shadow sticky top-0">
			<div class="container mx-auto px-4">
				<div class="flex items-center justify-between py-4">
					<div class="w-20 h-10">
						<img class="rounded md:w-30" src="/img/3PE.png">
						{{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-purple-600" viewBox="0 0 24 24">
								<path fill="currentColor" d="M14.5,16 C14.2238576,16 14,15.7761424 14,15.5 L14,9.5 C14,9.22385763 14.2238576,9 14.5,9 L16,9 C17.1045695,9 18,9.8954305 18,11 C18,11.4116588 17.8756286,11.7942691 17.6624114,12.1123052 C18.4414283,12.3856578 19,13.1275982 19,14 C19,15.1045695 18.1045695,16 17,16 L14.5,16 Z M15,15 L17,15 C17.5522847,15 18,14.5522847 18,14 C18,13.4477153 17.5522847,13 17,13 L15,13 L15,15 Z M15,12 L16,12 C16.5522847,12 17,11.5522847 17,11 C17,10.4477153 16.5522847,10 16,10 L15,10 L15,12 Z M12.9499909,4 L19.5,4 C20.8807119,4 22,5.11928813 22,6.5 L22,19.5 C22,20.8807119 20.8807119,22 19.5,22 L13.5,22 C12.2700325,22 11.2475211,21.1117749 11.0389093,19.9417682 C10.8653433,19.9799013 10.6850188,20 10.5,20 L4.5,20 C3.11928813,20 2,18.8807119 2,17.5 L2,4.5 C2,3.11928813 3.11928813,2 4.5,2 L10.5,2 C11.709479,2 12.7183558,2.85887984 12.9499909,4 Z M13,5 L13,17.5 C13,18.3179089 12.6072234,19.0440799 12,19.5001831 C12.0000989,20.3285261 12.6716339,21 13.5,21 L19.5,21 C20.3284271,21 21,20.3284271 21,19.5 L21,6.5 C21,5.67157288 20.3284271,5 19.5,5 L13,5 Z M8.56005566,11.4964303 C8.54036595,11.4987873 8.52032459,11.5 8.5,11.5 L6.5,11.5 C6.47967541,11.5 6.45963405,11.4987873 6.43994434,11.4964303 L5.96423835,12.6856953 C5.86168164,12.9420871 5.57069642,13.066795 5.31430466,12.9642383 C5.0579129,12.8616816 4.93320495,12.5706964 5.03576165,12.3143047 L7.03576165,7.31430466 C7.20339081,6.89523178 7.79660919,6.89523178 7.96423835,7.31430466 L9.96423835,12.3143047 C10.066795,12.5706964 9.9420871,12.8616816 9.68569534,12.9642383 C9.42930358,13.066795 9.13831836,12.9420871 9.03576165,12.6856953 L8.56005566,11.4964303 Z M8.16148352,10.5 L7.5,8.8462912 L6.83851648,10.5 L8.16148352,10.5 Z M10.5,3 L4.5,3 C3.67157288,3 3,3.67157288 3,4.5 L3,17.5 C3,18.3284271 3.67157288,19 4.5,19 L10.5,19 C11.3284271,19 12,18.3284271 12,17.5 L12,4.5 C12,3.67157288 11.3284271,3 10.5,3 Z M6.5,18 C6.22385763,18 6,17.7761424 6,17.5 C6,17.2238576 6.22385763,17 6.5,17 L8.5,17 C8.77614237,17 9,17.2238576 9,17.5 C9,17.7761424 8.77614237,18 8.5,18 L6.5,18 Z M15.5,20 C15.2238576,20 15,19.7761424 15,19.5 C15,19.2238576 15.2238576,19 15.5,19 L17.5,19 C17.7761424,19 18,19.2238576 18,19.5 C18,19.7761424 17.7761424,20 17.5,20 L15.5,20 Z"/>
							</svg> --}}
					</div>
					{{-- {{ $geocode }} --}}
					<div class="hidden sm:flex cursor-pointer sm:items-center">
						<a href="#LiveTracking"
							class="text-gray-800 text-sm font-semibold hover:text-purple-600 mb-1 tracking-tight">LIVE TRACKING</a>
						{{-- <a href="#" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mr-4">Products</a>
							<a href="#" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mr-4">Marketplace</a>
							<a href="#" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mr-4">Partners</a>
							<a href="#" class="text-gray-800 text-sm font-semibold hover:text-purple-600">Pricing</a> --}}
					</div>
					<div class="hidden sm:flex sm:items-center">
						{{-- <a href="#" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mr-4">Sign in</a> --}}
						<a href="{{ route('login') }}"
							class="text-gray-800 text-sm font-semibold border px-4 py-2 rounded-lg hover:text-purple-600 hover:border-purple-600">Sign
							In</a>
					</div>
					<div class="sm:hidden cursor-pointer">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-600 cursor-pointer"
							viewBox="0 0 24 24" onclick="toggle()">
							<path fill="currentColor"
								d="M12.9499909,17 C12.7183558,18.1411202 11.709479,19 10.5,19 C9.29052104,19 8.28164422,18.1411202 8.05000906,17 L3.5,17 C3.22385763,17 3,16.7761424 3,16.5 C3,16.2238576 3.22385763,16 3.5,16 L8.05000906,16 C8.28164422,14.8588798 9.29052104,14 10.5,14 C11.709479,14 12.7183558,14.8588798 12.9499909,16 L20.5,16 C20.7761424,16 21,16.2238576 21,16.5 C21,16.7761424 20.7761424,17 20.5,17 L12.9499909,17 Z M18.9499909,12 C18.7183558,13.1411202 17.709479,14 16.5,14 C15.290521,14 14.2816442,13.1411202 14.0500091,12 L3.5,12 C3.22385763,12 3,11.7761424 3,11.5 C3,11.2238576 3.22385763,11 3.5,11 L14.0500091,11 C14.2816442,9.85887984 15.290521,9 16.5,9 C17.709479,9 18.7183558,9.85887984 18.9499909,11 L20.5,11 C20.7761424,11 21,11.2238576 21,11.5 C21,11.7761424 20.7761424,12 20.5,12 L18.9499909,12 Z M9.94999094,7 C9.71835578,8.14112016 8.70947896,9 7.5,9 C6.29052104,9 5.28164422,8.14112016 5.05000906,7 L3.5,7 C3.22385763,7 3,6.77614237 3,6.5 C3,6.22385763 3.22385763,6 3.5,6 L5.05000906,6 C5.28164422,4.85887984 6.29052104,4 7.5,4 C8.70947896,4 9.71835578,4.85887984 9.94999094,6 L20.5,6 C20.7761424,6 21,6.22385763 21,6.5 C21,6.77614237 20.7761424,7 20.5,7 L9.94999094,7 Z M7.5,8 C8.32842712,8 9,7.32842712 9,6.5 C9,5.67157288 8.32842712,5 7.5,5 C6.67157288,5 6,5.67157288 6,6.5 C6,7.32842712 6.67157288,8 7.5,8 Z M16.5,13 C17.3284271,13 18,12.3284271 18,11.5 C18,10.6715729 17.3284271,10 16.5,10 C15.6715729,10 15,10.6715729 15,11.5 C15,12.3284271 15.6715729,13 16.5,13 Z M10.5,18 C11.3284271,18 12,17.3284271 12,16.5 C12,15.6715729 11.3284271,15 10.5,15 C9.67157288,15 9,15.6715729 9,16.5 C9,17.3284271 9.67157288,18 10.5,18 Z" />
						</svg>
					</div>
				</div>
				<div id="menu" class="hidden cursor-pointer block sm:hidden bg-white border-t-2 py-2">
					<div class="flex flex-col">
						<a href="#LiveTracking"
							class="text-gray-800 text-sm font-semibold hover:text-purple-600 mb-1">LIVE TRACKING</a>
						{{-- <a href="#" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mb-1">Marketplace</a>
						<a href="#" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mb-1">Partners</a>
						<a href="#" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mb-1">Pricing</a> --}}
						<div class="flex justify-between items-center border-t-2 pt-2">
							{{-- <a href="#" class="text-gray-800 text-sm font-semibold hover:text-purple-600 mr-4">Sign in</a> --}}
							<a href="{{ route('login') }}"
								class="text-gray-800 text-sm font-semibold border px-4 py-1 rounded-lg hover:text-purple-600 hover:border-purple-600">Sign
								In</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class=" flex flex-col items-center flex-1 h-full justify-center py-12 px-3">
			<div class="w-full text-center">
				<div class="mb-4">
					{{-- <form action="#"> --}}
						<div class="max-w-sm mx-auto p-1 pr-0 flex items-center">
							<input type="input" id="shipment" placeholder="search HWB"
								class="flex-1 appearance-none rounded shadow p-3 text-grey-dark mr-1 focus:outline-none">
							<button type="submit" onclick="ReadDataShipments()"
								class="appearance-none bg-teal-900 text-white text-base font-semibold tracking-wide uppercase p-3 rounded shadow hover:bg-green-700">TRACK
								NOW</button>
						</div>
					{{-- </form> --}}
				</div>
			</div>
			{{-- {{ $geocode }} --}}
				<div class="w-full w-px rounded-full empty-state">
				<p id="shipmentsNotFound" class="">Shipment not found</p>
				<div id="detailshipment" class="hidden py-4 mb-4 shadow w-full sm:text-center appearance- rounded text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
					<label class="block font-serif text-xl text-gray-700 text-sm font-bold w-full py-1 px-3 text-center"
						for="SHIPMENT">
						SHIPMENT
					</label>
					<p id="code_shipment"
						class="tracking-tight text-gray-600 font-serif text-xl font-mono justify-center w-auto text-center items-center">
						
					</p>
					<label class="block font-serif text-xl text-gray-700 text-sm text-center font-bold w-full py-1 px-3"
						for="PO CODE">
						PO CODE
					</label>
					<p id="po_code" class="tracking-tight text-gray-600 justify-center text-xl text-center">
						DN93483001
					</p>
					<label class="block font-serif text-xl text-gray-700 text-sm text-center font-bold w-full py-1 px-3"
						for="STATUS">
						STATUS
					</label>
					<p id="status" class="tracking-tight text-gray-600 justify-center text-xl text-center">
						DELIVERED
					</p>
					<label class="block font-serif text-xl text-gray-700 text-sm text-center font-bold w-full py-1 px-3"
						for="HISTORY">
						HISTORY
					</label>
					<div class="w-full text-center py-4">
						<button
							class="modal-open bg-transparent border border-gray-500 hover:border-teal-500 text-gray-500 hover:text-green-700 font-bold py-2 px-4 rounded-full">
							Show Detail History
						</button>
					</div>
				</div>
			</div>
			<div class="flex mb-4 empty-state">
				<div class="w-1/2">
					<p id="originnotfound" class="">Origin not found</p>
					<div id="origins" class="w-full hidden focus:shadow-outline">
						<div
							class="mb-4 shadow sm:text-left w-full py-10 px-3 appearance-none border rounded w-full py-8 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
							<label class="block text-gray-700 text-sm font-bold mb-1" for="Status">
								Origin
							</label>
							<p id="originaddress" class="text-gray-600 sm:text-left w-full py-5 px-3">
							</p>
						</div>
					</div>
				</div>
				&nbsp;
				<div class="w-1/2">
					<p id="destinationnotfound" class="">Destination not found</p>
					<div id="destinations" class="w-full hidden focus:shadow-outline">
						<div
							class="mb-4 shadow sm:text-left w-full py-10 px-3 appearance-none border rounded w-full py-8 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
							<label class="block text-gray-700 text-sm font-bold mb-1" for="Status">
								Destination
							</label>
							<p id="destinationaddress" class="text-gray-600 sm:text-left w-full py-5 px-3">
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
		<div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

		<div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

			<div
				class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
				<svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
					viewBox="0 0 18 18">
					<path
						d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z">
					</path>
				</svg>
				<span class="text-sm">( Tutup / Esc )</span>
			</div>
			<div class="modal-content py-4 text-left px-6">
				<div class="flex justify-between items-center pb-3">
					<div class="z-50">
						<div class="flex mb-4 bg-gray-200">
							<div class="w-full focus:shadow-outline">
								<div
									class="o-layout u-mrgn-left--0 u-border--1--sand-dark u-mrgn-bottom--4 u-border-radius--2">
								</div>
								<div class="c-modal__content">
									<div
										class="o-layout u-mrgn-left--0 u-border--1--sand-dark u-mrgn-bottom--4 u-border-radius--2">
										<div class="o-layout__item u-bg--sand-light u-pad--2 u-border-radius--2">
											<div class="u-display-flex u-display-flex--v-center">
												<div
													class="c-icon-duotone--medium c-icon-duotone--product-history u-pad-top--1 u-mrgn-right--1"><p class="font-serif text-green-900">3PE</p>
												</div>
												<div class="u-txt--small">
													Update history terakhir:
												</div>
											</div>
											<div class="u-display-flex u-display-flex--v-center">
												<div
													class="c-icon-duotone--medium c-icon-duotone--product-history u-pad-top--1 u-mrgn-right--1">
												</div>
												<div class="u-txt--small">
													26 November 2019 21.57 WIB
												</div>
											</div>
											<div class="u-mrgn-left--5 courier-text">	
												<div class="u-txt--small">
													Untuk mempercepat pengiriman, kamu bisa menghubungi
													<strong>Customer Service</strong> Kami di nomor telepon <strong>(021) ...</strong>
												</div>
												<ul></ul>
												{{-- <li>
													<strong class="u-txt--small">(021)
														5020-0050</strong>
												</li> --}}
											</div>
											<div class="u-mrgn-left--5 u-txt--small courier-more">Lihat
												selengkapnya</div>
										</div>
									</div>
									<table class="c-table c-table--zebra">
										<thead>
											<tr>
												<th class="u-1of12"></th>
												<th class="u-4of12">Tanggal</th>
												<th class="u-7of12">Status Pengiriman</th>
											</tr>
										</thead>
										<tbody>
											@php
											foreach ($dataSHIPMENTS as $key => $value) {
											# code...
											$names[$key] = $value->status_name;
											}
											foreach ($shipment as $key => $value) {
											# code...
											$dataShipment = $value->datetime;
											}
											@endphp
											@if (isset($names[0]) == "draft")
											<tr>
												@if(isset($names[1]) == "new")
												<td class="u-1of12 c-dot-steps u-valign-top">
													<div class="c-dot-steps__circle">
														<span class="c-icon c-icon--check-circle"></span>
													</div>
												</td>
												@else
												<td class="u-valign-top">
													<span class="c-icon c-icon--check-circle"></span>
												</td>
												@endif
												<td class="u-4of12 u-fg--ash-dark u-valign-top">
													{{ $dataShipment }}
												</td>
												<td class="u-2of12 c-dot-steps">
													<div class="o-layout">
														<div class="o-layout__item">
															Dalam Proses - Transitsss
														</div>
													</div>
												</td>
											</tr>
											@else
											@endif
											@if (isset($names[1]) == "new")
											<tr>
												@if(isset($names[0]) == "draft")
												@if(isset($names[2]) == "process")
												<td class="u-1of12 c-dot-steps u-valign-top">
													<div class="c-dot-steps__circle">
														<span class="c-icon c-icon--check-circle"></span>
													</div>
												</td>
												@else
												<td class="u-valign-top">
													<span class="c-icon c-icon--check-circle"></span>
												</td>
												@endif
												@else
												<td class="u-1of12 c-dot-steps u-valign-top">
													<div class="c-dot-steps__circle">
														<span class="c-icon c-icon--check-circle"></span>
													</div>
												</td>
												@endif
												<td class="u-4of12 u-fg--ash-dark u-valign-top">
													{{ $dataShipment }}
												</td>
												<td class="u-7of12">
													<div class="o-layout">
														<div class="o-layout__item">
															Dalam Proses - Transit
														</div>
													</div>
												</td>
											</tr>
											@else
											@endif
											@if (isset($names[2]) == "process")
											<tr>
												@if(isset($names[1]) == "new")
												@if(isset($names[3]) == "done")
												<td class="u-1of12 c-dot-steps u-valign-top">
													<div class="c-dot-steps__circle">
														<span class="c-icon c-icon--check-circle"></span>
													</div>
												</td>
												@else
												<td class="u-valign-top">
													<span class="c-icon c-icon--check-circle"></span>
												</td>
												@endif
												@else
												<td class="u-1of12 c-dot-steps u-valign-top">
													<div class="c-dot-steps__circle">
														<span class="c-icon c-icon--check-circle"></span>
													</div>
												</td>
												@endif
												<td class="u-4of12 u-fg--ash-dark u-valign-top">
													{{ $dataShipment }}
												</td>
												<td class="u-7of12">
													<div class="o-layout">
														<div class="o-layout__item">
															Dalam Proses - Transit test
														</div>
													</div>
												</td>
											</tr>
											@else
											@endif
											@if (isset($names[3]) == "done")
											<tr>
												@if(isset($names[2]) == "process" || isset($names[1]) ==
												"new" ||
												isset($names[0]) ==
												"draft")
												<td class="u-2of12 c-dot-steps u-valign-top">
													<div
														class="c-dot-steps__circle c-dot-steps__circle--active c-dot-steps__circle--last">
														<span class=""></span>
													</div>
												</td>
												@else
												<td class="u-valign-top">
													<span class="c-icon c-icon--check-circle"></span>
												</td>
												@endif
												<td class="u-4of12 u-fg--ash-dark u-valign-top">
													26 Juni 2019
												</td>
												<td class="u-7of12">
													<div class="o-layout">
														<div class="o-layout__item u-txt--bold">
															Diterima oleh Penerima Paket
														</div>
															<div id="open" class="o-layout__item">
																<a class="c-link-rd" onclick="OtoggleDetailTransaksi()">Lihat Detail</a>
															</div>
															<div id="appsd" class="o-layout__item hidden">
																<a class="c-link-rd" onclick="REtoggleDetailTransaksi()">Lihat Detail</a>
															</div>
													</div>
													<div id="detailTransaksi" class="o-layout u-mrgn-top--2 cursor-pointer hidden">
														<div class="o-layout__item">
															<div class="o-layout" id="js-shipping-detail-items">
																<div class="o-layout__item">
																	<div class="o-flag o-flag--micro">
																		<div
																			class="o-flag__head u-pad-bottom--2 u-valign-top c-dot-steps">
																			<div
																				class="c-dot-steps__circle c-dot-steps__circle--active c-dot-steps__circle--last">
																				<span class=""></span>
																			</div>
																		</div>
																		<div class="o-flag__body u-valign-top">
																			<div class="u-txt--small">
																				:DELIVERED
																			</div>
																			<div class="u-txt--small">
																				FIXED CSS ALL SO FAR
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="o-layout">
																<div class="o-layout__item">
																	<a class="c-link-rd" onclick="CtoggleDetailTransaksi()">
																		Lihat
																		lebih
																		sedikit</a>
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>
											@else
											@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- <div class="flex justify-center"> --}}
					{{-- <button class="justify-center modal-close px-1 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Tutup
						Histori</button> --}}
				{{-- </div> --}}
			</div>
		
		</div>
	</div>
	</div>
	<script>

		const menu = document.getElementById('menu');
		const toggle = () => menu.classList.toggle("hidden");
		const detailTransaksi = document.getElementById('detailTransaksi');
		const reetailTransaksi = document.getElementById('detailTransaksi');
		const cldetailTransaksi = document.getElementById('detailTransaksi');
		const open = document.getElementById('open');
		const opened = document.getElementById('opened');
		const appsd = document.getElementById('appsd');
		const OtoggleDetailTransaksi = () => detailTransaksi.classList.toggle("hidden") || open.classList.toggle("hidden");
		const REtoggleDetailTransaksi = () => reetailTransaksi.classList.toggle("hidden") || appsd.classList.toggle("hidden") || opened.classList.toggle("hidden"); 
		const CtoggleDetailTransaksi = () => appsd.classList.toggle("hidden") || cldetailTransaksi.classList.toggle("hidden");

		var openmodal = document.querySelectorAll('.modal-open')
		for (var i = 0; i < openmodal.length; i++) {
			openmodal[i].addEventListener('click', function (event) {
				event.preventDefault()
				toggleModal()
			})
		}

		const overlay = document.querySelector('.modal-overlay')
		overlay.addEventListener('click', toggleModal)

		var closemodal = document.querySelectorAll('.modal-close')
		for (var i = 0; i < closemodal.length; i++) {
			closemodal[i].addEventListener('click', toggleModal)
		}

		document.onkeydown = function (evt) {
			evt = evt || window.event
			var isEscape = false
			if ("key" in evt) {
				isEscape = (evt.key === "Escape" || evt.key === "Esc")
			} else {
				isEscape = (evt.keyCode === 27)
			}
			if (isEscape && document.body.classList.contains('modal-active')) {
				toggleModal()
			}
		};

		function toggleModal() {
			const body = document.querySelector('body')
			const modal = document.querySelector('.modal')
			modal.classList.toggle('opacity-0')
			modal.classList.toggle('pointer-events-none')
			body.classList.toggle('modal-active')
		}

		const status = response => {

			if (response.status >= 200 && response.status < 300) {
				return Promise.resolve(response)
			}

			return Promise.reject(new Error(response.statusText))
		}

		async function ReadDataShipments() {
			const code = document.getElementById('shipment').value;
			let promise = new Promise((resolve, reject) => {
				setTimeout(() => resolve(5), 1000)
			});

			let result = await promise; 

			console.log("start")
			const dtSH = document.getElementById("detailshipment")
			const origins = document.getElementById("origins")
			const destinations = document.getElementById("destinations")
			const status = document.getElementById("status")
			const codes = document.getElementById("code_shipment")
			const shipmentsNotFound = document.getElementById("shipmentsNotFound")
			
			const SearchShipments = (code) => {
				return fetch(`http://devyour-api.co.id/geolocation/tracking/${code}`, {
						method: 'POST',
                        cache: 'no-cache',
                        credentials: 'same-origin',
                        redirect: 'follow',
                        referrer: 'no-referrer',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
							'Content-Type': 'application/json'}
						}
					)
				.then(response => response.json())
				.then(datashipment => datashipment)
				.then(address => fetch(`http://devyour-api.co.id/geolocation/tracking/address/${address.order_id}`))
				.then(responseAddress => responseAddress.json())
				.then(scs => scs)
			}
				
			SearchShipments(code).then(function (asyncdata) {
				console.log(asyncdata)
				if(!isEmptyObject(asyncdata)){
					console.log("founded")
					// search last index of array
					// console.log(asyncdata.slice(-1)[0])
					// asyncdata.map(d => d)
					document.getElementById("code_shipment").innerHTML = asyncdata.order_id
					document.getElementById("status").innerHTML = asyncdata.cek_status_transaction.status_name
					document.getElementById("originaddress").innerHTML = asyncdata.origin_address
					document.getElementById("destinationaddress").innerHTML = asyncdata.destination_address
					document.getElementById('shipmentsNotFound').style.display='none'
					document.getElementById('originnotfound').style.display='none'
					document.getElementById('destinationnotfound').style.display='none'
					document.getElementById('detailshipment').style.display='inline'

					document.getElementById('origins').style.display='inline'
					document.getElementById('destinations').style.display='inline'

					dtSH.classList.toggle("hidden")
					origins.classList.toggle("hidden")
					destinations.classList.toggle("hidden")
				} else {
					console.log("not found")
					console.log(asyncdata)
					document.getElementById('detailshipment').style.display='none'
					document.getElementById('shipmentsNotFound').style.display='inline'

					document.getElementById('originnotfound').style.display='inline'
					document.getElementById('destinationnotfound').style.display='inline'
					
					document.getElementById('origins').style.display='none'
					document.getElementById('destinations').style.display='none'
					
				}
			});
		 
		}

		function isEmptyObject(obj){
			return JSON.stringify(obj) === '{}';
		}

	</script>
</body>

</html>
</body>