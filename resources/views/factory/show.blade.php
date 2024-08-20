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
                <h5 class="card-title">Factory Detail</h5>
            </div>
            <div class="card-body">
                <p class="card-text text-start">Recieved date: {{ $factory->received_date }}</p>
                <p class="card-text text-start">Initial process: {{ $factory->initial_process }}</p>
                <p class="card-text text-start">Finished quantity: {{ $factory->semi_finished_quantity }}</p>
                <p class="card-text text-start">Finished quality: {{ $factory->semi_finished_quality }}</p>
                <p class="card-text text-start">Factory name: {{ $factory->factory_name }}</p>
                <p class="card-text text-start">Factory address: {{ $factory->factory_address }}</p>
                <p class="card-text text-start">NFT Token ID: {{ $factory->nft_token_id }}</p>
                <img src="{{ asset('storage/images/' . $factory->image) }}" alt="factory Image" class="img-fluid">
            </div>
        </div>
    </div>

    <script src="{{ asset('js/popper.min.js') }}">
        <script src="{{ asset('js/bootstrap.min.js') }}">
        </body>
</html >