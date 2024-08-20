@extends('layout.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Certifications</h1>
    <a href="{{ route('certification.create') }}" class="btn btn-warning">Create New Certification</a>
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
                <th>Batik Name</th>
                <th>Certification Number</th>
                <th>Issue Date</th>
                <th>Test Results</th>
                <th>Image</th>
                <th>Monitor</th>
                <th>QR Code</th>
                <th>Download</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($certifications as $certification)
            <tr>
                <td>{{ $certification->id }}</td>
                <td>{{ $certification->batik_type }}</td>
                <td>{{ $certification->certificate_number }}</td>
                <td>{{ $certification->issue_date }}</td>
                <td>{{ $certification->test_results }}</td>
                <td>
                    @if($certification->image)
                    <span class="img-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="{{ asset('storage/images/' . $certification->image) }}">View Image</span>
                    @else
                    No Image
                    @endif
                </td>
                <td>
                    <a href="{{ route('monitoring.show', $certification->monitoring_id) }}" class="monitor-link">Monitor</a>
                </td>
                <td>
                    @if($certification->qrcode)
                    <img src="{{ asset('storage/qrcodes/' . $certification->qrcode) }}" alt="QR Code" style="width: 100px;">
                    @else
                    No QR Code
                    @endif
                </td>
                <td>
                    <a href="{{ route('certificate', $certification->id) }}" class="btn btn-warning btn-sm" download>Download PDF</a>
                <td>
                    @if($certification->is_ref != 1)
                    <a href="{{ route('certification.edit', $certification->id) }}" class="btn btn-warning btn-sm btn-icon">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('certification.destroy', $certification->id) }}" method="POST" class="d-inline delete-form">
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
                <h5 class="modal-title" id="imageModalLabel">Certification Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Certification Image" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@endsection