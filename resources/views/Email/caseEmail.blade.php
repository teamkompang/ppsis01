@component('mail::message')
<bold>(Classification - Proprietary)</bold><br><br>

<center><bold><h1>PPSIS - Case Update</h1></bold></center>

<br>

<br>Case Ref. No.: SIS{{ $mailData['refno'] }}
<br>From: {{ $mailData['from'] }}, ( {{ $mailData['company'] }} )
<br>Details: {{ $mailData['details'] }} 




<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->
Please Login to <a href="google.com">PUNB Panel Solicitors Information System (PPSIS)</a> to reply or update related cases.

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
