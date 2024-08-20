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
                <img src="{{ asset('storage/images/' . $certification->image) }}" alt="certification Image" class="img-fluid">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-7+/S3MHvZjEUF0MRRqkKRRxNuN8Pbq1XuFzAYvcN/fXtPyhrhjjdOvuZ2M9dPf/e" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRac7mFf2R6VJ9Ht5V4UpEVg9KNV5vhFeEJvF0/jz" crossorigin="anonymous"></script>
</body>
</html>
