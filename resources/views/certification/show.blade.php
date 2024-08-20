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
                <h5 class="card-title">Certification Detail</h5>
            </div>
            <div class="card-body">
                <p class="card-text text-start">Test result: {{ $certification->test_results }}</p>
                <p class="card-text text-start">Certificate number: {{ $certification->certificate_number }}</p>
                <p class="card-text text-start">Issue date: {{ $certification->issue_date }}</p>
                <p class="card-text text-start">NFT Token ID: {{ $certification->nft_token_id }}</p>
                <img src="{{ asset('storage/images/' . $certification->image) }}" alt="certification Image"
                    class="img-fluid">
            </div>
        </div>
    </div>

    <script src="{{ asset('js/popper.min.js') }}">
        <script src="{{ asset('js/bootstrap.min.js') }}">
        </body>
</html >