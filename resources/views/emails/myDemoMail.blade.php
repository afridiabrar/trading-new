
<!DOCTYPE html>
<html>
<head>
 <title>Trading</title>
</head>
<body>

 <h1>{{$details['mail_title']}}</h1>
 <p>Full Name: {{$details['f_name'] }}  {{$details['l_name'] }}</p>
 <p>Email:  {{$details['email'] }} </p>
 <p>Mobile Number: {{$details['phone'] }}</p>
 @if($details['subject'])
 <p>Subject: {{$details['subject'] }}</p>
 <p>Message: {{$details['message'] }}</p>
@endif
 <p>Thank you</p>

</body>
</html>
