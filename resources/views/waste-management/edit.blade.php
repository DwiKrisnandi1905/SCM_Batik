<form action="{{ route('waste.update', $waste->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
        <label for="waste_type">Waste Type:</label>
        <input type="text" id="waste_type" name="waste_type" value="{{ old('waste_type', $waste->waste_type) }}" required>
    </div>
    <div>
        <label for="management_method">Management Method:</label>
        <input type="text" id="management_method" name="management_method" value="{{ old('management_method', $waste->management_method) }}" required>
    </div>
    <div>
        <label for="management_results">Management Results:</label>
        <input type="text" id="management_results" name="management_results" value="{{ old('management_results', $waste->management_results) }}" required>
    </div>
    <div>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
    </div>
    <div>
        <button type="submit">Update</button>
    </div>
</form>