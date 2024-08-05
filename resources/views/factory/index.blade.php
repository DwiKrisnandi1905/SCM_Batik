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
    .img-link {
        position: relative;
        display: inline-block;
        font-size: 16px;
        font-weight: bold;
        color: #007bff;
        text-decoration: none;
        transition: color 0.3s, transform 0.3s;
        cursor: pointer;
    }
    .img-link::after {
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
    .img-link:hover::after {
        transform: scaleX(1);
        transform-origin: bottom left;
    }
    .img-link:hover {
        color: #0056b3;
        transform: scale(1.1);
    }
</style>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>factorys</h1>
    <a href="{{ route('factory.create') }}" class="btn btn-primary">Create New factory</a>
</div>
<div class="table-wrapper">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>received_date</th>
                <th>initial_process</th>
                <th>semi_finished_quantity</th>
                <th>semi_finished_quality </th>
                <th>factory_name</th>
                <th>factory_address</th>
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
                    <td>{{ $factory->semi_finished_quality  }}</td>
                    <td>{{ $factory->factory_name}}</td>
                    <td>{{ $factory->factory_address}}</td>
                    <td>
                        @if($factory->image)
                            <span class="img-link" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="{{ asset('storage/images/' . $factory->image) }}">View Image</span>
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <a href="">Monitor</a>
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

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">factory Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="factory Image" class="img-fluid">
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
</script>
@endsection

