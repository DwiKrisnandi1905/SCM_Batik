<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Role</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .gradient-custom {
            background: #ffcc00;
            background: -webkit-linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
            background: linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
        }

        @media (min-width: 768px) {
            .gradient-form {
                height: 100vh !important;
            }
        }
        @media (min-width: 769px) {
            .gradient-custom {
                border-top-right-radius: .3rem;
                border-bottom-right-radius: .3rem;
            }
        }

        .btn-custom {
            background-color: #ffb347;
            border-color: #ffb347;
            color: #fff;
            transition: background-color 0.3s, border-color 0.3s, box-shadow 0.3s;
        }

        .btn-custom:hover {
            background-color: #ff8c00;
            border-color: #ff8c00;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .card {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 0.25rem;
        }

        body, html {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-3 mx-md-4">
                                <div class="text-center">
                                    <img src="{{ asset('img/logo_batiks.png') }}" style="width: 100px;" alt="logo">
                                    <h4 class="mt-4 mb-4 pb-1">SCM Batik</h4>
                                </div>

                                <form action="{{ route('roles.store') }}" method="POST">
                                    @csrf
                                    <p>Please select your role</p>

                                    <div class="form-group mb-3">
                                        <label for="role" class="form-label">Role:</label>
                                        <select class="form-control" id="role" name="role_id" required>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="text-center">
                                        <button class="btn btn-custom btn-block fa-lg mb-3" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-custom">
                            <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                <h4 class="mb-4">SCM Batik</h4>
                                <p class="small mb-0">SCM Batik adalah aplikasi web yang mengelola dan mengoptimalkan rantai pasokan industri batik. Dengan antarmuka user-friendly, aplikasi ini memudahkan pemantauan produksi, distribusi, dan inventaris produk batik. SCM Batik mendukung kolaborasi antara produsen, distributor, dan pengecer, meningkatkan efisiensi dan transparansi dalam rantai pasokan, serta mengintegrasikan teknologi modern untuk mendukung pertumbuhan industri batik.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
