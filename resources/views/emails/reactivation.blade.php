<!DOCTYPE html>
<html>
<head>
    <title>JustShareMedia License</title>
</head>
<body>
<div style="height:100%;margin:0;padding:0;width:100%">
    <img style="margin: 0 auto; width: 34%; margin-left: 33%" src="{{ $message->embed(public_path() . '/images/24139930-91bf-4032-9fa9-0a10646cb8d3.jpg') }}" alt="">
    <div style="text-align: center; font-family: Poppins; font-size: 32px; width: 50%; margin: 0 auto; color: black; margin-bottom: 30px; margin-top: 30px"><b>Baby Come Back</b></div>
    <div style="text-align: center; font-family: Poppins; font-size: 24px; width: 50%; margin: 0 auto; margin-bottom: 20px; color: black">We were sorry to see you go, but that doesn't mean we don't still care for you.</div>
    <div style="text-align: center; font-family: Poppins; font-size: 24px; width: 50%; margin: 0 auto; margin-bottom: 20px; color: black">We know marketing can be cyclical, you can always resume your subscription whenever you are ready.</div>
    <div style="text-align: center; font-family: Poppins; font-size: 24px;  width: 50%; margin: 0 auto; margin-bottom: 20px; color: black">Check out some of our <a style="text-decoration: none" href="{{ route('public.gallery') }}">latest videos</a>!</div>
    <div style="text-align: center; font-family: Poppins; font-size: 12px;  width: 50%; margin: 0 auto; margin-top: 50px"><a target="_blank" href="{{ route('reactivate-email-cancel', $code) }}">Unsubscribe from mailing list</a></div>
</div>
</body>
</html>
