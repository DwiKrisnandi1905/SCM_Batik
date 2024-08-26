@extends('layout.app')

@section('content')
    
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Factories</h1>
    <a href="{{ route('factory.create') }}" class="btn btn-warning">Create New Factory</a>
</div>

@if(session('success'))
    <div class="alert success">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
        {{ session('error') }}
    </div>
@endif

<div class="table-wrapper">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Received Date</th>
                <th>Initial Process</th>
                <th>Semi-Finished Quantity</th>
                <th>Semi-Finished Quality</th>
                <th>Factory Name</th>
                <th>Factory Address</th>
                <th>Image</th>
                <th>Monitor</th>
                <th>QR Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factories as $factory)
                <tr>
                    <td>{{ $factory->id }}</td>
                    <td>{{ $factory->received_date }}</td>
                    <td>{{ $factory->initial_process }}</td>
                    <td>{{ $factory->semi_finished_quantity }}</td>
                    <td>{{ $factory->semi_finished_quality }}</td>
                    <td>{{ $factory->factory_name }}</td>
                    <td>{{ $factory->factory_address }}</td>
                    <td>
                        @if($factory->image)
                            <span class="img-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="{{ asset('storage/images/' . $factory->image) }}">View Image</span>
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                    <a href="{{ route('monitoring.show', $factory->monitoring_id) }}" class="monitor-link">Monitor</a>
                    </td>
                    <td>
                        @if($factory->qrcode)
                            <img src="{{ asset('storage/qrcodes/' . $factory->qrcode) }}" alt="QR Code" style="width: 100px;">
                        @else
                            No QR Code
                        @endif
                    </td>
                    <td class="actions">
                        @if($factory->is_ref != 1)
                            <a href="{{ route('factory.edit', $factory->id) }}" class="btn btn-warning btn-sm btn-icon">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('factory.destroy', $factory->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-icon delete-button">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @else
                        <span class="disabled-button">Disabled</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Factory Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Factory Image" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
@endsection
