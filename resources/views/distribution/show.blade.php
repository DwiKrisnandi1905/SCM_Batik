<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factory Details</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/show.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Distribution Detail</h5>
            </div>
            <div class="card-body">
                <p class="card-text text-start">Test result: {{ $distribution->destination }}</p>
                <p class="card-text text-start">Certificate number: {{ $distribution->quantity }}</p>
                <p class="card-text text-start">Shipment date: {{ $distribution->shipment_date }}</p>
                <p class="card-text text-start">Tracking number: {{ $distribution->tracking_number }}</p>
                <p class="card-text text-start">Recieve date: {{ $distribution->recieved_date }}</p>
                <p class="card-text text-start">Recieve name: {{ $distribution->recieved_name }}</p>
                <p class="card-text text-start">Recieve Condition: {{ $distribution->recieved_condition }}</p>
                <p class="card-text text-start">NFT Token ID: {{ $distribution->nft_token_id }}</p>
                <img src="{{ asset('storage/images/' . $distribution->image) }}" alt="distribution Image"
                    class="img-fluid">
            </div>
        </div>
    </div>

    <script src="{{ asset('js/popper.min.js') }}">
        <script src="{{ asset('js/bootstrap.min.js') }}">
        </body>
</html >