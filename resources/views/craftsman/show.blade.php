<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factory Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
            max-width: 400px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            background-color: #ff7043;
            color: #fff;
            padding: 20px;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .card-body {
            padding: 20px;
            text-align: center;
        }

        .card-text {
            font-size: 0.8rem;
            color: #555;
            margin-bottom: 10px;
        }

        .card img {
            border-radius: 12px;
            margin-top: 20px;
            max-height: 100%;
            object-fit: contain;
            width: 60%;
        }

        @media (max-width: 768px) {
            .card-header,
            .card-body {
                text-align: center;
            }

            .card img {
                max-height: 250px;
            }
        }
    </style>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-7+/S3MHvZjEUF0MRRqkKRRxNuN8Pbq1XuFzAYvcN/fXtPyhrhjjdOvuZ2M9dPf/e" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRac7mFf2R6VJ9Ht5V4UpEVg9KNV5vhFeEJvF0/jz" crossorigin="anonymous"></script>
</body>
</html>
