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
                <h5 class="card-title">Waste Management Detail</h5>
            </div>
            <div class="card-body">
                <p class="card-text text-start">Waste type: {{ $wasteManagement->waste_type }}</p>
                <p class="card-text text-start">Management method: {{ $wasteManagement->management_method }}</p>
                <p class="card-text text-start">Management result: {{ $wasteManagement->management_results }}</p>
                <p class="card-text text-start">NFT Token ID: {{ $wasteManagement->nft_token_id }}</p>
                <img src="{{ asset('storage/images/' . $wasteManagement->image) }}" alt="wasteManagement Image" class="img-fluid">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-7+/S3MHvZjEUF0MRRqkKRRxNuN8Pbq1XuFzAYvcN/fXtPyhrhjjdOvuZ2M9dPf/e" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRac7mFf2R6VJ9Ht5V4UpEVg9KNV5vhFeEJvF0/jz" crossorigin="anonymous"></script>
</body>
</html>
