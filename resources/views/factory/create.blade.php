<!-- resources/views/factories/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Create Factory</title>
</head>
<body>
    <h1>Create Factory</h1>
    <form action="{{ route('factory.store') }}" method="POST">
        @csrf
        <label for="harvest_id">Harvest:</label>
        <select id="harvest_id" name="harvest_id" required>
            @foreach($harvests as $harvest)
                <option value="{{ $harvest->id }}">{{ $harvest->id }}</option>
            @endforeach
        </select><br><br>

        <label for="received_date">Received Date:</label>
        <input type="datetime-local" id="received_date" name="received_date" required><br><br>

        <label for="initial_process">Initial Process:</label>
        <input type="text" id="initial_process" name="initial_process" required><br><br>

        <label for="semi_finished_quantity">Semi-Finished Quantity:</label>
        <input type="number" step="0.01" id="semi_finished_quantity" name="semi_finished_quantity" required><br><br>

        <label for="semi_finished_quality">Semi-Finished Quality:</label>
        <input type="text" id="semi_finished_quality" name="semi_finished_quality" required><br><br>

        <label for="factory_name">Factory Name:</label>
        <input type="text" id="factory_name" name="factory_name" required><br><br>

        <label for="factory_address">Factory Address:</label>
        <input type="text" id="factory_address" name="factory_address" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>