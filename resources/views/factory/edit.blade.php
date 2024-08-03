<!-- resources/views/factory/edit.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Edit Factory</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Factory</h1>
        <form action="{{ route('factory.update', $factory->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="harvest_id">Harvest ID:</label>
                <input type="number" id="harvest_id" name="harvest_id" class="form-control" value="{{ $factory->harvest_id }}" required>
            </div>

            <div class="form-group">
                <label for="received_date">Received Date:</label>
                <input type="datetime-local" id="received_date" name="received_date" class="form-control" value="{{ $factory->received_date ? (new DateTime($factory->received_date))->format('Y-m-d\TH:i') : '' }}" required>
            </div>

            <div class="form-group">
                <label for="initial_process">Initial Process:</label>
                <input type="text" id="initial_process" name="initial_process" class="form-control" value="{{ $factory->initial_process }}" required>
            </div>

            <div class="form-group">
                <label for="semi_finished_quantity">Semi-Finished Quantity:</label>
                <input type="number" step="0.01" id="semi_finished_quantity" name="semi_finished_quantity" class="form-control" value="{{ $factory->semi_finished_quantity }}" required>
            </div>

            <div class="form-group">
                <label for="semi_finished_quality">Semi-Finished Quality:</label>
                <input type="text" id="semi_finished_quality" name="semi_finished_quality" class="form-control" value="{{ $factory->semi_finished_quality }}" required>
            </div>

            <div class="form-group">
                <label for="factory_name">Factory Name:</label>
                <input type="text" id="factory_name" name="factory_name" class="form-control" value="{{ $factory->factory_name }}" required>
            </div>

            <div class="form-group">
                <label for="factory_address">Factory Address:</label>
                <input type="text" id="factory_address" name="factory_address" class="form-control" value="{{ $factory->factory_address }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>