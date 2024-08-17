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
                    <span class="monitor-link" data-bs-toggle="modal" data-bs-target="#monitorModal" data-wastemanagement="{{ json_encode($wasteManagement) }}">Monitor</span>
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

<!-- Monitor Modal -->
<div class="modal fade" id="monitorModal" tabindex="-1" aria-labelledby="monitorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="monitorModalLabel">Monitor Waste Management</h5>
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
        var wasteManagement = JSON.parse(button.getAttribute('data-wastemanagement'));

        var statuses = [{
                label: 'Harvest',
                status: wasteManagement.harvest
            },
            {
                label: 'Factory',
                status: wasteManagement.factory
            },
            {
                label: 'Craftsman',
                status: wasteManagement.craftsman
            },
            {
                label: 'Certificator',
                status: wasteManagement.certificator
            },
            {
                label: 'Waste Management',
                status: wasteManagement.waste_management
            },
            {
                label: 'Distributor',
                status: wasteManagement.distributor
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
        // var progressContainers = document.querySelectorAll('.progress-container div');
        // progressContainers.forEach(function(container, index) {
        //     var progressBar = container.querySelector('.progress-bar');
        //     var tooltipText = container.querySelector('.tooltip-text');
        //     progressBar.className = 'progress-bar'; // Reset class
        //     progressBar.classList.add(statuses[index].status ? 'bg-success' : 'bg-danger');
        //     tooltipText.innerText = statuses[index].label;
        // });
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