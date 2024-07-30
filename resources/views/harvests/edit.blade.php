<!-- resources/views/harvests/edit.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Edit Harvest</title>
</head>
<body>
    <div>
        <h1>Edit Harvest</h1>
        <form action="{{ route('harvest.update', $harvest->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="material_type">Material Type:</label>
                <input type="text" id="material_type" name="material_type" value="{{ old('material_type', $harvest->material_type) }}" required>
            </div>

            <div>
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $harvest->quantity) }}" required>
            </div>

            <div>
                <label for="quality">Quality:</label>
                <input type="text" id="quality" name="quality" value="{{ old('quality', $harvest->quality) }}" required>
            </div>

            <div>
                <label for="delivery_info">Delivery Info:</label>
                <input type="text" id="delivery_info" name="delivery_info" value="{{ old('delivery_info', $harvest->delivery_info) }}" required>
            </div>

            <div>
                <label for="delivery_date">Delivery Date:</label>
                <input type="date" id="delivery_date" name="delivery_date" value="{{ old('delivery_date', $harvest->delivery_date) }}" required>
            </div>

            <div>
                <label for="image">Image:</label>
                @if($harvest->image)
                    <img src="{{ asset('storage/' . $harvest->image) }}" alt="Harvest Image" width="100">
                @endif
                <input type="file" id="image" name="image">
            </div>

            <div>
                <button type="submit">Update Harvest</button>
            </div>
        </form>
    </div>
</body>
</html>