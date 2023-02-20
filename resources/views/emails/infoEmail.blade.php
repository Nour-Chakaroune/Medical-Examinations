
@component('mail::message')
# {{$mailData['title']}}
Dear {{$mailData['body']}}, <br><br>
The request results are:
@component('mail::table')
| Medical Examination | Result |
| ------- | ------- |
@foreach ($res as $r)
| {{$r->type}} | {{$r->Status}} |
@endforeach
@endcomponent
<br>
Regards,<br>

@endcomponent
