@extends('layout.app')

@section('content')
<style>
    .btn-warning {
        color: #fff;
        background-color: #ff8c00;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        border: 2px solid #fff;
    }

    .btn-warning:hover {
        color: #ff8c00;
        background-color: #fff;
        border: 2px solid #ff8c00;
    }
</style>
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edit Certification</h1>
        <a href="{{ route('certification.index') }}" class="btn btn-warning">
            Back
        </a>
    </div>
    <form action="{{ route('certification.update', $certification->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="craftsman_id">Option ID:</label>
            <select id="craftsman_id" name="craftsman_id" class="form-control" required>
                @foreach($craftsmen as $craftsmen)
                    <option value="{{ $craftsmen->id }}">{{ $craftsmen->production_details }} -
                        {{$craftsmen->finished_quantity}} - {{$craftsmen->completion_date}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="batik_type">Batik Type:</label>
            <input type="text" id="batik_type" name="batik_type" class="form-control"
                value="{{ $certification->batik_type }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="test_results">Certificate test_results:</label>
            <input type="text" id="test_results" name="test_results" class="form-control"
                value="{{ $certification->test_results }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="certificate_number">Certificate Number:</label>
            <input type="text" id="certificate_number" name="certificate_number" class="form-control"
                value="{{ $certification->certificate_number  }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="issue_date">Issue Date:</label>
            <input type="datetime-local" id="issue_date" name="issue_date" class="form-control"
                value="{{ $certification->issue_date}}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            @if($certification->image)
                <img src="{{ asset('storage/images/' . $certification->image) }}" alt="certification Image"
                    class="img-thumbnail mb-2" width="100">
            @endif
            <input type="file" class="form-control" id="image" name="image">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection