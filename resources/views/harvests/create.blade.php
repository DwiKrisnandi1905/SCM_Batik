<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Harvest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Create Harvest</h1>
        <form action="{{ route('harvest.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="material_type" class="form-label">Material Type:</label>
                <input type="text" class="form-control" id="material_type" name="material_type" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" step="any" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="quality" class="form-label">Quality:</label>
                <input type="text" class="form-control" id="quality" name="quality" required>
            </div>
            <div class="mb-3">
                <label for="delivery_info" class="form-label">Delivery Info:</label>
                <input type="text" class="form-control" id="delivery_info" name="delivery_info" required>
            </div>
            <div class="mb-3">
                <label for="delivery_date" class="form-label">Delivery Date:</label>
                <input type="datetime-local" class="form-control" id="delivery_date" name="delivery_date" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
