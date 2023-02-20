
@component('mail::message')
# {{$mailData['title']}}
Dear {{$mailData['body']}}, <br><br>
The credentials of your account are: <br>
<strong>User Name:</strong> {{$mailData['username']}} <br>
<strong>Password:</strong> {{$mailData['password']}} <br><br>
Thanks,<br>
@endcomponent
