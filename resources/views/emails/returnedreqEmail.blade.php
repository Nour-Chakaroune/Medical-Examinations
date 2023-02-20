
@component('mail::message')
# {{$mailData['title']}}
Dear {{$mailData['body']}}, <br><br>
Unfortunately, your request has been returned. <br>
Please review the below reason and resubmit again. <br><br>
<strong>Reason:</strong> {{$reason}} <br><br>
Regards,<br>
@endcomponent
