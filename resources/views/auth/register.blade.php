<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        .btn-outline-custom {
            border-color: #ffb347;
            color: #ffb347;
            transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
        }

        .btn-outline-custom:hover {
            background-color: #ffb347;
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .card {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 0.25rem;
            transition: border-color 0.3s, box-shadow 0.3s;
            border: 1.5px solid rgb(163, 163, 163);
        }

        .form-control:focus {
            border-color: #ffb347;
            box-shadow: 0 0 10px rgba(255, 179, 71, 0.5);
        }

        .form-outline {
            position: relative;
        }

        .form-outline label {
            position: absolute;
            top: 0;
            left: 0.75rem;
            font-size: 1rem;
            color: #999;
            transition: all 0.3s;
        }

        .form-outline input:focus + label,
        .form-outline input:not(:placeholder-shown) + label {
            top: -1.5rem;
            left: 0.75rem;
            font-size: 0.65rem;
            color: #ff8c00;
        }

        .text-white p {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .text-center img {
            filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.2));
        }

        .remember-me {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .remember-me .form-check {
            margin-bottom: 0;
        }

        .forgot-password {
            color: #ff8c00;
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-password:hover {
            color: #ffb347;
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
                                    <img src="img/logo_batiks.png" style="width: 100px;" alt="logo">
                                    <h4 class="mt-4 mb-4 pb-1">SCM Batik</h4>
                                </div>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" required placeholder=" ">
                                        <label for="name" class="mt-1">Name</label>
                                        @error('name')
                                        <div>{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder=" ">
                                        <label for="email" class="mt-1">Email address</label>
                                        @error('email')
                                        <div>{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" id="password" class="form-control" name="password" required placeholder=" ">
                                        <label for="password" class="mt-1">Password</label>
                                        @error('password')
                                        <div>{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div data-mdb-input-init class="form-outline mb-4">
                                        <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required placeholder=" ">
                                        <label for="password-confirm" class="mt-1">Confirm Password</label>
                                    </div>

                                    <div class="text-center">
                                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-custom btn-block fa-lg mb-3" type="submit">Register</button>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="mb-0 me-2">Already have an account?</p>
                                        <a href="{{ route('login') }}" class="btn btn-outline-custom" data-mdb-button-init data-mdb-ripple-init>Log in</a>
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
</body>
</html>
