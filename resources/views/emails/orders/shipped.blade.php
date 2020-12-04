@component('mail::message')
# Order Shipped

Your order has been shipped!

@component('mail::button', ['url' => url('invoice-customer', $id), 'color' => 'red'])
View Order
@endcomponent

@component('mail::panel')
Email : {{ $Email }}<br />
Nama  : {{ $Nama }}
<hr>
@component('mail::table')
|     #ORDER ID    |
| :---------------:|
|  <div style="text-transform:uppercase">{{$OrderId}}</div>
@endcomponent
<hr>
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent