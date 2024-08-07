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
    <h1>Factories</h1>
    <a href="{{ route('factory.create') }}" class="btn btn-primary">Create New Factory</a>
</div>
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($factory as $factory)
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
                        <span class="monitor-link" data-bs-toggle="modal" data-bs-target="#monitorModal" data-factory="{{ json_encode($factory) }}">Monitor</span>
                    </td>
                    <td class="actions">
                        <a href="{{ route('factory.edit', $factory->id) }}" class="btn btn-warning btn-sm btn-icon">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('factory.destroy', $factory->id) }}" method="POST" class="d-inline">
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

<div class="modal fade" id="monitorModal" tabindex="-1" aria-labelledby="monitorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="monitorModalLabel">Monitor Factory</h5>
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
        var factoryData = JSON.parse(button.getAttribute('data-factory'));
        var statuses = [
            { label: 'Harvest', status: factory.harvest },
            { label: 'Factory', status: factory.factory },
            { label: 'Craftsman', status: factory.craftsman },
            { label: 'Certificator', status: factory.certificator },
            { label: 'Waste Management', status: factory.waste_management },
            { label: 'Distributor', status: factory.distributor }
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
