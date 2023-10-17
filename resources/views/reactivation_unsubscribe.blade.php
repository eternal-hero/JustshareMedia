<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Unsubscribed</title>
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <link
        href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap"
        rel="stylesheet" type="text/css"/>
    <style>
        .wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo {
            margin-top: 50px;
            margin-bottom: 30px;
        }

        .title {
            font-family: 'Poppins';
            font-size: 32px;
            margin-bottom: 20px;
        }

        .msg {
            font-family: 'Poppins';
            font-size: 22px;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="logo">
        <img src="{{ asset('assets/images/just-share-media-logo.png') }}" alt="JustShare Logo">
    </div>
    <div class="title">
        We're sorry to see you go!
    </div>
    <div class="msg">
        You have been successfully <b>unsubscribed</b> from the email list.
    </div>
</div>
</body>
</html>
