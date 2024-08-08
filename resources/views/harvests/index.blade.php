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
    th, td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .img-link, .monitor-link {
        position: relative;
        display: inline-block;
        font-size: 16px;
        font-weight: bold;
        color: #007bff;
        text-decoration: none;
        transition: color 0.3s, transform 0.3s;
        cursor: pointer;
    }
    .img-link::after, .monitor-link::after {
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
    .img-link:hover::after, .monitor-link:hover::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }
    .img-link:hover, .monitor-link:hover {
        color: #0056b3;
        transform: scale(1.1);
    }

    .progress-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .progress-container div {
        width: 100%;
        margin: 0 -1px; /* Adjust margin to remove gaps between progress bars */
        position: relative;
    }
    .progress-container .progress {
        margin: 0; /* Remove margin from progress */
        border-radius: 0; /* Ensure no border radius on progress */
    }
    .progress-container .progress-bar {
        border-radius: 0; /* Ensure no border radius on progress-bar */
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
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Harvests</h1>
    <a href="{{ route('harvest.create') }}" class="btn btn-primary">Create New Harvest</a>
</div>
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
                        <span class="monitor-link" data-bs-toggle="modal" data-bs-target="#monitorModal" data-harvest="{{ json_encode($harvest) }}">Monitor</span>
                    </td>
                    <td class="actions">
                        <a href="{{ route('harvest.edit', $harvest->id) }}" class="btn btn-warning btn-sm btn-icon">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('harvest.destroy', $harvest->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm btn-icon" onclick="return confirm('Are you sure you want to delete this item?');">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
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

<!-- Monitor Modal -->
<div class="modal fade" id="monitorModal" tabindex="-1" aria-labelledby="monitorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="monitorModalLabel">Monitor Harvest</h5>
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
    imageModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var imageUrl = button.getAttribute('data-bs-image');
        var modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
    });

    var monitorModal = document.getElementById('monitorModal');
    monitorModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var harvest = JSON.parse(button.getAttribute('data-harvest'));
        
        var statuses = [
            { label: 'Harvest', status: harvest.harvest },
            { label: 'Factory', status: harvest.factory },
            { label: 'Craftsman', status: harvest.craftsman },
            { label: 'Certificator', status: harvest.certificator },
            { label: 'Waste Management', status: harvest.waste_management },
            { label: 'Distributor', status: harvest.distributor }
        ];

        var progressContainer = monitorModal.querySelector('.progress-container');
        progressContainer.innerHTML = '';

        statuses.forEach(function(item) {
            var progressDiv = document.createElement('div');
            var progressBarDiv = document.createElement('div');
            var progressBar = document.createElement('div');
            var tooltipText = document.createElement('span');

            progressBarDiv.className = 'progress';
            progressBar.className = 'progress-bar bg-' + (item.status ? 'success' : 'danger');
            progressBar.style.width = '100%';
            progressBar.role = 'progressbar';

            tooltipText.className = 'tooltip-text';
            tooltipText.innerText = item.label;

            progressDiv.appendChild(progressBarDiv);
            progressBarDiv.appendChild(progressBar);
            progressDiv.appendChild(tooltipText);
            progressContainer.appendChild(progressDiv);
        });
    });
</script>

@endsection
