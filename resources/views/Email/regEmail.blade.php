@component('mail::message')

<bold>(Classification - Proprietary)</bold><br><br>

<center><bold><h1>PPSIS User Registration</h1></bold></center>

<br><br>Please register your details by clicking button Register button below.


@component(
    'mail::button', 
    ['url' => route('accept', $invite->token)],
   )
Register

@endcomponent

or you can <a href="{{ route('accept', $invite->token) }}">Click here</a> to Register

Regards,<br>
{{ config('app.name') }}
<br><br>
Perbadanan Usahawan Nasional Berhad
<br>Tingkat 10, Block 1B, Plaza Sentral
<br>Jalan Stesen Sentral 5
<br>Kuala Lumpur Sentral
<br>50470 Kuala Lumpur 
<br>
<br>GL     : 03-2785 1515 
<br>DL     : 03-2773 5747 

@endcomponent