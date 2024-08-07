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
        color: #0056b3; /* Darker shade for hover */
        transform: scale(1.1);
    }
</style>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>certificationss</h1>
        <a href="{{ route('certification.create') }}" class="btn btn-primary">Create New certifications</a>
    </div>
    <div class="table-wrapper">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Factory</th>
                    <th>production_details</th>
                    <th>finished_quantity</th>
                    <th>completion_date </th>
                    <th>Image</th>
                    <th>Monitor</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($certifications as $certification)
                    <tr>
                        <td>{{ $certification->id }}</td>
                        <td>{{ $certification->factory->factory_name }}</td>
                        <td>{{ $certification->production_details }}</td>
                        <td>{{ $certification->finished_quantity }}</td>
                        <td>{{ $certification->completion_date }}</td>
                        <td>image</td>
                        <td>monitor</td>
                        <td>
                            <a href="{{ route('certification.edit', $certification->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('certification.destroy', $certification->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">certifications Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="certifications Image" class="img-fluid">
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
