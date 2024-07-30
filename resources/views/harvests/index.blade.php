<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harvests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Harvests</h1>
            <a href="{{ route('harvest.create') }}" class="btn btn-primary">Create New Harvest</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Material Type</th>
                    <th>Quantity</th>
                    <th>Quality</th>
                    <th>Delivery Info</th>
                    <th>Delivery Date</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($harvests as $harvest)
                    <tr>
                        <td>{{ $harvest->id }}</td>
                        <td>{{ $harvest->material_type }}</td>
                        <td>{{ $harvest->quantity }}</td>
                        <td>{{ $harvest->quality }}</td>
                        <td>{{ $harvest->delivery_info }}</td>
                        <td>{{ $harvest->delivery_date }}</td>
                        <td>
                            @if($harvest->image)
                                <img src="{{ asset('storage/' . $harvest->image) }}" alt="Harvest Image" width="100">
                            @else
                                No Image
                            @endif
                        </td>
                        <td class="d-flex">
                            <a href="{{ route('harvest.edit', $harvest->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="{{ route('harvest.destroy', $harvest->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
