@extends('layout.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Waste Management Records</h1>
    <a href="{{ route('waste.create') }}" class="btn btn-warning">Create New Record</a>
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
                <th>Waste Type</th>
                <th>Management Method</th>
                <th>Management Results</th>
                <th>Image</th>
                <th>Monitor</th>
                <th>QR Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wasteManagements as $wasteManagement)
            <tr>
                <td>{{ $wasteManagement->id }}</td>
                <td>{{ $wasteManagement->waste_type }}</td>
                <td>{{ $wasteManagement->management_method }}</td>
                <td>{{ $wasteManagement->management_results }}</td>
                <td>
                    @if($wasteManagement->image)
                    <span class="img-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="{{ asset('storage/images/' . $wasteManagement->image) }}">View Image</span>
                    @else
                    No Image
                    @endif
                </td>
                <td>
                <a href="{{ route('monitoring.show', $wasteManagement->monitoring_id) }}" class="monitor-link">Monitor</a>
                </td>
                <td>
                    @if($wasteManagement->qrcode)
                        <img src="{{ asset('storage/qrcodes/' . $wasteManagement->qrcode) }}" alt="QR Code" style="width: 100px;">
                    @else
                        No QR Code
                    @endif
                </td>
                <td>
                    @if($wasteManagement->is_ref != 1)
                        <a href="{{ route('waste.edit', $wasteManagement->id) }}" class="btn btn-warning btn-sm btn-icon">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('waste.destroy', $wasteManagement->id) }}" method="POST" class="d-inline delete-form">
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
                <h5 class="modal-title" id="imageModalLabel">Waste Management Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Waste Management Image" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
@endsection