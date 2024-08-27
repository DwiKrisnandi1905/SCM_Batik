@extends('layout.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Add Factory ref</h1>
        <a href="{{ route('craftsman.index') }}" class="btn btn-warning">
            Back
        </a>
    </div>
    <form action="{{ route('craftsman.ref.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="craftsman_id" value="{{ $craftsman->id }}">
        <div class="form-group">
            <label for="factory_id">Factory:</label>
            <select id="factory_id" name="factory_id" class="form-control" required>
                @foreach($factories as $factory)
                    <option value="{{ $factory->id }}">{{$factory->received_date}} - {{ $factory->factory_name }} -
                        {{$factory->initial_process}} - {{$factory->semi_finished_quantity}} -
                        {{$factory->semi_finished_quality}}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection