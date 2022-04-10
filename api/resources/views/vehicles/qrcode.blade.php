<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
    <style>
        .page-break {
            page-break-after: always;
        }

    </style>
</head>

<body style="width: 100%">
    <div style="border: 2px solid black; margin: 0 20%;padding-bottom:8%;">
        <div style="margin: 10% 8% 0 8%">
            <img src="{{ public_path('images/itera.png') }}" height="45" width="40" alt="">
            <img src="{{ public_path('images/tubaba.png') }}" height="45" width="110" style="margin: 0 5" alt="">
            <img src="{{ public_path('images/logo_tubaba.png') }}" height="45" width="45" style="margin: 0 5" alt="">
            <img src="{{ public_path('images/dishub.png') }}" height="45" width="45" style="margin: 0 5" alt="">
            <img src="{{ public_path('images/kominfo_tubaba.png') }}" height="45" width="45" alt="">
        </div>
        <div style="margin: 0 20%">
            <img src="{{ public_path('vehicle/' . $vehicle->id . '.png') }}" height="250" width="250" alt="">
        </div>
        <div style="height: 12px; margin-top: -10%;">
            <h4 style="float:left; margin-left: 30%; width:100px;">
                {{ $vehicle->vehicleType->type }}
            </h4>
            <h4 style="float:right; margin-right: 30%;">
                {{ $vehicle->serial_number }}
            </h4>
        </div>
    </div>
</body>

</html>
