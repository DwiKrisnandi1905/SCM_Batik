@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Edit Certification</h1>
        <form action="{{ route('certification.update', $certification->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="craftsman_id">Option ID:</label>
                <select id="craftsman_id" name="craftsman_id" class="form-control" required>
                    @foreach($craftsmen as $craftsmen)
                        <option value="{{ $craftsmen->id }}">{{ $craftsmen->production_details }} - {{$craftsmen->finished_quantity}} - {{$craftsmen->completion_date}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="test_results">Certificate test_results:</label>
                <input type="text" id="test_results" name="test_results" class="form-control" value="{{ $certification->test_results }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="certificate_number">Certificate Number:</label>
                <input type="text" id="certificate_number" name="certificate_number" class="form-control" value="{{ $certification->certificate_number  }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="issue_date">Issue Date:</label>
                <input type="datetime-local" id="issue_date" name="issue_date" class="form-control" value="{{ $certification->issue_date}}" required>
            </div>

            <div class="form-group mb-3">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" class="form-control">

                @if($certification->image)
                    <img src="{{ asset('storage/' . $certification->image) }}" alt="certification Image" class="img-fluid mt-2" style="max-width: 200px;">
                @endif

            </div>

            

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
@endsection
