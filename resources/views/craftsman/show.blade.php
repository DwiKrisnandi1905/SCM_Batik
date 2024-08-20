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
                <h5 class="card-title">Craftsman Detail</h5>
            </div>
            <div class="card-body">
                <p class="card-text text-start">Production details: {{ $craftsman->production_details }}</p>
                <p class="card-text text-start">Finished quantity: {{ $craftsman->finished_quantity }}</p>
                <p class="card-text text-start">completion_date: {{ $craftsman->completion_date }}</p>
                <p class="card-text text-start">NFT Token ID: {{ $craftsman->nft_token_id }}</p>
                <img src="{{ asset('storage/images/' . $craftsman->image) }}" alt="craftsman Image" class="img-fluid">
            </div>
        </div>
    </div>

    <script src="{{ asset('js/popper.min.js') }}">
        <script src="{{ asset('js/bootstrap.min.js') }}">
        </body>
</html >