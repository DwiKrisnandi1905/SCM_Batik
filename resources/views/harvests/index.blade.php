@extends('layout.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Harvests</h1>
    <a href="{{ route('harvest.create') }}" class="btn btn-warning">Create New Harvest</a>
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
                <th>Material Type</th>
                <th>Quantity</th>
                <th>Quality</th>
                <th>Delivery Info</th>
                <th>Delivery Date</th>
                <th>Image</th>
                <th>Monitor</th>
                <th>QR Code</th>
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
                            <span class="img-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="{{ asset('storage/images/' . $harvest->image) }}">View Image</span>
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('monitoring.show', $harvest->monitoring_id) }}" class="monitor-link">Monitor</a>
                    </td>
                    <td>
                        @if($harvest->qrcode)
                            <img src="{{ asset('storage/qrcodes/' . $harvest->qrcode) }}" alt="QR Code" style="width: 100px;">
                        @else
                            No QR Code
                        @endif
                    </td>
                    <td class="actions">
                        @if($harvest->is_ref != 1)
                            <a href="{{ route('harvest.edit', $harvest->id) }}" class="btn btn-warning btn-sm btn-icon">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('harvest.destroy', $harvest->id) }}" method="POST" class="d-inline delete-form">
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
                <h5 class="modal-title" id="imageModalLabel">Harvest Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Harvest Image" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
@endsection
