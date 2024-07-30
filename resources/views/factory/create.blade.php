<!-- resources/views/harvests/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Create Harvest</title>
</head>
<body>
    <div>
        <h1>Create Harvest</h1>
        <form action="{{ route('harvest.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="material_type">Material Type:</label>
                <input type="text" id="material_type" name="material_type" required>
            </div>
            <div>
                <label for="quantity">Quantity:</label>
                <input type="number" step="any" id="quantity" name="quantity" required>
            </div>
            <div>
                <label for="quality">Quality:</label>
                <input type="text" id="quality" name="quality" required>
            </div>
            <div>
                <label for="delivery_info">Delivery Info:</label>
                <input type="text" id="delivery_info" name="delivery_info" required>
            </div>
            <div>
                <label for="delivery_date">Delivery Date:</label>
                <input type="date" id="delivery_date" name="delivery_date" required>
            </div>
            <div>
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>