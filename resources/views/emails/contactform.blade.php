<!DOCTYPE html>
<html>
<head>
    <title>Contact Form Submission</title>
</head>
<body>
    <h1>Contact Form Submission</h1>
    <p><b>Name:</b> {{ $data['name'] }}</p>
    <p><b>Email:</b> {{ $data['email'] }}</p>
    <h3>Message:</h3>
    <p>{!! nl2br($data['message']) !!}</p>
</body>
</html>