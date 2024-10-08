@extends('layout.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Craftsmen</h1>
    <a href="{{ route('craftsman.create') }}" class="btn btn-warning">Create New Craftsman</a>
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
                <th>Factory</th>
                <th>Production Details</th>
                <th>Finished Quantity</th>
                <th>Completion Date</th>
                <th>Image</th>
                <th>Monitor</th>
                <th>QR Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($craftsmen as $craftsman)
                <tr>
                    <td>{{ $craftsman->id }}</td>
                    <td>
                        <a href="{{ route('craftsman.ref.create', $craftsman->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-link"></i>
                        </a>
                    </td>
                    <td>{{ $craftsman->production_details }}</td>
                    <td>{{ $craftsman->finished_quantity }}</td>
                    <td>{{ $craftsman->completion_date }}</td>
                    <td>
                        @if($craftsman->image)
                            <span class="img-link" data-bs-toggle="modal" data-bs-target="#imageModal"
                                data-bs-image="{{ asset('storage/images/' . $craftsman->image) }}">View Image</span>
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('monitoring.show', $craftsman->monitoring_id) }}" class="monitor-link">Monitor</a>
                    </td>
                    <td>
                        @if($craftsman->qrcode)
                            <img src="{{ asset('storage/qrcodes/' . $craftsman->qrcode) }}" alt="QR Code" style="width: 100px;">
                        @else
                            No QR Code
                        @endif
                    </td>
                    <td>
                        @if($craftsman->is_ref != 1)
                            <a href="{{ route('craftsman.edit', $craftsman->id) }}" class="btn btn-warning btn-sm btn-icon">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('craftsman.destroy', $craftsman->id) }}" method="POST"
                                class="d-inline delete-form">
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
                <h5 class="modal-title" id="imageModalLabel">Craftsman Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Craftsman Image" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Monitor Modal -->
<div class="modal fade" id="monitorModal" tabindex="-1" aria-labelledby="monitorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="monitorModalLabel">Monitor Craftsman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="progress-container">
                    <div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                        </div>
                        <span class="tooltip-text">Harvest</span>
                    </div>
                    <div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                        </div>
                        <span class="tooltip-text">Factory</span>
                    </div>
                    <div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                        </div>
                        <span class="tooltip-text">Craftsman</span>
                    </div>
                    <div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                        </div>
                        <span class="tooltip-text">Certificator</span>
                    </div>
                    <div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                        </div>
                        <span class="tooltip-text">Waste Management</span>
                    </div>
                    <div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                        </div>
                        <span class="tooltip-text">Distributor</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>

@endsection