@extends('layout.app')

@section('content')

<style>
    .table-wrapper {
        overflow-x: auto;
    }

    table {
        min-width: 800px;
        width: 100%;
        table-layout: auto;
    }

    th,
    td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-link {
        position: relative;
        display: inline-block;
        font-size: 16px;
        font-weight: bold;
        color: #007bff;
        text-decoration: none;
        transition: color 0.3s, transform 0.3s;
        cursor: pointer;
    }

    .btn-link::after {
        content: '';
        position: absolute;
        width: 100%;
        transform: scaleX(0);
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: #007bff;
        transform-origin: bottom right;
        transition: transform 0.25s ease-out;
    }

    .btn-link:hover::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }

    .btn-link:hover {
        color: #0056b3;
        transform: scale(1.1);
    }

    .btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon i {
        margin-right: 5px;
    }

    .progress-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .progress-container div {
        width: 100%;
        margin: 0 -1px;
        /* Adjust margin to remove gaps between progress bars */
        position: relative;
    }

    .progress-container .progress {
        margin: 0;
        /* Remove margin from progress */
        border-radius: 0;
        /* Ensure no border radius on progress */
    }

    .progress-container .progress-bar {
        border-radius: 0;
        /* Ensure no border radius on progress-bar */
    }

    .tooltip-text {
        visibility: hidden;
        opacity: 0;
        width: 100px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;
        position: absolute;
        z-index: 1;
        bottom: 150%;
        left: 50%;
        margin-left: -50px;
        transition: opacity 0.3s;
    }

    .tooltip-text::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: black transparent transparent transparent;
    }

    .progress-container div:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }

    .alert {
        padding: 20px;
        background-color: #f44336;
        color: white;
        margin-bottom: 15px;
    }

    .alert.success {
        background-color: #4CAF50;
    }

    .alert.info {
        background-color: #2196F3;
    }

    .alert.warning {
        background-color: #ff9800;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }

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
</script>

@endsection