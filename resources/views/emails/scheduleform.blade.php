<!DOCTYPE html>
<html>
<head>
    <title>Schedule Form Submission</title>
</head>
<body>
    <h1>Schedule Form Submission</h1>
    <p><b>Name:</b> {{ $data['firstName'] }} {{ $data['lastName'] }}</p>
    <p><b>Company:</b> {{ $data['companyName'] }}</p>
    <p><b>Phone:</b> {{ $data['phone'] }}</p>
    <p><b>Email:</b> {{ $data['email'] }}</p>
</body>
</html>