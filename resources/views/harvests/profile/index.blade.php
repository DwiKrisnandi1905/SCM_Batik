@extends('harvests.layout.app')

@section('content')
<style>
    .card {
        border-radius: 1.25rem;
        overflow: hidden;
    }

    .card-body {
        padding: 2rem;
    }

    .card-header {
        border-radius: 0.75rem 0.75rem 0 0;
    }

    .btn-primary {
        background-color: #ffcc00;
        border-color: #ffcc00;
        border-radius: 1.5rem;
        padding: 0.75rem 1.5rem;
        font-size: 1.125rem;
    }

    .btn-primary:hover {
        background-color: #ffb347;
        border-color: #ffb347;
    }

    .text-name {
        color: #ffcc00;
    }

    .text-dark {
        color: #343a40;
    }

    .border-light {
        border-color: #f8f9fa !important;
    }

    .border-bottom {
        border-bottom: 1px solid #dee2e6 !important;
    }

    .shadow-lg {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .rounded-4 {
        border-radius: 1.5rem;
    }

    .blur-background {
        background: #ffcc00;
        background: -webkit-linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
        background: linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
        border-radius: 0.75rem;
        padding: 1rem;
    }
    .bg-gold {
        background: #ffcc00;
        background: -webkit-linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
        background: linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
    }

    .info-row {
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .info-title {
        font-weight: bold;
        color: #343a40;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card mb-4 shadow-lg border-light rounded-4">
                <div class="card-body text-center">
                    <img src="img/bagus.png" alt="avatar" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #ffcc00;">
                    <h5 class="my-3 font-weight-bold text-name">John Doe</h5>
                    <h6 class="font-weight-bold text-name mb-1">Harvest</h6>
                    <a href="#" class="btn btn-primary btn-lg mt-3">Edit Profile</a>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mb-4 shadow-lg border-light rounded-4">
                <div class="card-header bg-gold text-white text-center border-bottom border-light">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="info-row blur-background">
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 info-title">Full Name</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0 text-white fw-bold">Johnatan Smith</p>
                            </div>
                        </div>
                    </div>
                    <div class="info-row blur-background">
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 info-title">Email</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0 text-white fw-bold">example@example.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="info-row blur-background">
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 info-title">Phone</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0 text-white fw-bold">(123) 456-7890</p>
                            </div>
                        </div>
                    </div>
                    <div class="info-row blur-background">
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="mb-0 info-title">Address</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-0 text-white fw-bold">Bay Area, San Francisco, CA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
