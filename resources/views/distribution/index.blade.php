@extends('layout.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Distribution Records</h1>
    <a href="{{ route('distribution.create') }}" class="btn btn-warning">Create New Record</a>
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
                <th>Destination</th>
                <th>Quantity</th>
                <th>Shipment Date</th>
                <th>Tracking Number</th>
                <th>Received Date</th>
                <th>Receiver Name</th>
                <th>Received Condition</th>
                <th>Image</th>
                <th>Monitor</th>
                <th>QR Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($distribution as $dist)
            <tr>
                <td>{{ $dist->id }}</td>
                <td>{{ $dist->destination }}</td>
                <td>{{ $dist->quantity }}</td>
                <td>{{ $dist->shipment_date }}</td>
                <td>{{ $dist->tracking_number }}</td>
                <td>{{ $dist->received_date }}</td>
                <td>{{ $dist->receiver_name }}</td>
                <td>{{ $dist->received_condition }}</td>
                <td>
                    @if($dist->image)
                    <span class="img-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="{{ asset('storage/images/' . $dist->image) }}">View Image</span>
                    @else
                    No Image
                    @endif
                </td>
                <td>
                    <span class="btn-link monitor-link" data-bs-toggle="modal" data-bs-target="#monitorModal" data-distribution="{{ json_encode($dist) }}">Monitor</span>
                </td>
                <td>
                    @if($dist->qrcode)
                        <img src="{{ asset('storage/qrcodes/' . $dist->qrcode) }}" alt="QR Code" style="width: 100px;">
                    @else
                        No QR Code
                    @endif
                </td>
                <td>
                    @if($dist->is_ref != 1)
                        <a href="{{ route('distribution.edit', $dist->id) }}" class="btn btn-warning btn-sm btn-icon">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('distribution.destroy', $dist->id) }}" method="POST" class="d-inline delete-form">
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
                <h5 class="modal-title" id="monitorModalLabel">Monitor Distribution</h5>
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

<script>
    var imageModal = document.getElementById('imageModal');
    imageModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var imageUrl = button.getAttribute('data-bs-image');
        var modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
    });

    var monitorModal = document.getElementById('monitorModal');
    monitorModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var distribution = JSON.parse(button.getAttribute('data-distribution'));

        var statuses = [{
                label: 'Harvest',
                status: distribution.harvest
            },
            {
                label: 'Factory',
                status: distribution.factory
            },
            {
                label: 'Craftsman',
                status: distribution.craftsman
            },
            {
                label: 'Certificator',
                status: distribution.certificator
            },
            {
                label: 'Waste Management',
                status: distribution.waste_management
            },
            {
                label: 'Distributor',
                status: distribution.distributor
            }
        ];

        var progressContainer = monitorModal.querySelector('.progress-container');
        progressContainer.innerHTML = '';

        statuses.forEach(function(item) {
            var progressDiv = document.createElement('div');
            var progressBarDiv = document.createElement('div');
            progressBarDiv.className = 'progress';

            var progressBar = document.createElement('div');
            progressBar.className = 'progress-bar';

            if (item.status === 'completed') {
                progressBar.className += ' bg-success';
                progressBar.style.width = '100%';
            } else {
                progressBar.className += ' bg-danger';
                progressBar.style.width = '100%';
            }

            var tooltipText = document.createElement('span');
            tooltipText.className = 'tooltip-text';
            tooltipText.innerText = item.label;

            progressDiv.appendChild(progressBarDiv);
            progressBarDiv.appendChild(progressBar);
            progressDiv.appendChild(tooltipText);
            progressContainer.appendChild(progressDiv);
        });
    });

    document.querySelectorAll('.delete-button').forEach(function(button) {
        button.addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff8008',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    popup: 'gradient-custom',
                    title: 'swal2-title',
                    content: 'swal2-content',
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-warning',
                    icon: 'swal2-icon swal2-warning'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        });
    });

    setTimeout(function() {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s ease-out';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 500);
        });
    }, 3000);
</script>

@endsection