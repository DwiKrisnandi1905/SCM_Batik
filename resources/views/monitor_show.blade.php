<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Details</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <header class="text-center mb-4">
        <h1>Monitoring Details</h1>
    </header>

    @if ($monitoring->harvest)
        <section class="mb-4">
            <article class="card">
                <header class="card-header bg-success text-white">
                    <h2 class="h4">Harvest</h2>
                </header>
                <div class="card-body">
                    <p><strong>Material Type:</strong> {{ $monitoring->harvest->material_type }}</p>
                    <p><strong>Quantity:</strong> {{ $monitoring->harvest->quantity }}</p>
                    <p><strong>Quality:</strong> {{ $monitoring->harvest->quality }}</p>
                    <p><strong>Delivery Info:</strong> {{ $monitoring->harvest->delivery_info }}</p>
                    <p><strong>Delivery Date:</strong> {{ $monitoring->harvest->delivery_date }}</p>
                    <div class="text-start my-3">
                        <img src="{{ asset('storage/images/' . $monitoring->harvest->image) }}" alt="Harvest Image" class="img-fluid rounded" style="height: 200px; width: auto;">
                    </div>
                    <div class="text-start">
                        <img src="{{ asset('storage/qrcodes/' . $monitoring->harvest->qrcode)}}" alt="QR Code" class="img-fluid" style="height: 200px; width: auto;">
                    </div>
                </div>
            </article>
        </section>
    @endif

    @if ($craftsmanFactories->isNotEmpty())
        <section class="mb-4">
            <article class="card">
                <header class="card-header bg-info text-white">
                    <h2 class="h4">Factories</h2>
                </header>
                <div class="card-body">
                    @foreach ($craftsmanFactories as $factory)
                        <div class="mb-4">
                            <p><strong>Factory Name:</strong> {{ $factory->factory_name }}</p>
                            <p><strong>Factory Location:</strong> {{ $factory->factory_address }}</p>
                            <div class="text-start my-3">
                                <img src="{{ asset('storage/images/' . $factory->image) }}" alt="Factory Image" class="img-fluid rounded" style="height: 200px; width: auto;">
                            </div>
                            <div class="text-start">
                                <img src="{{ asset('storage/qrcodes/' . $factory->qrcode)}}" alt="QR Code" class="img-fluid" style="height: 200px; width: auto;">
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </article>
        </section>
    @endif

    @if ($monitoring->craftsman)
        <section class="mb-4">
            <article class="card">
                <header class="card-header bg-warning text-dark">
                    <h2 class="h4">Craftsman</h2>
                </header>
                <div class="card-body">
                    <p><strong>Production Details:</strong> {{ $monitoring->craftsman->production_details }}</p>
                    <p><strong>Finished Quantity:</strong> {{ $monitoring->craftsman->finished_quantity }}</p>
                    <p><strong>Completion Date:</strong> {{ $monitoring->craftsman->completion_date }}</p>
                    <div class="text-start my-3">
                        <img src="{{ asset('storage/images/' . $monitoring->craftsman->image) }}" alt="Craftsman Image" class="img-fluid rounded" style="height: 200px; width: auto;">
                    </div>
                    <div class="text-start">
                        <img src="{{ asset('storage/qrcodes/' . $monitoring->craftsman->qrcode)}}" alt="QR Code" class="img-fluid" style="height: 200px; width: auto;">
                    </div>
                </div>
            </article>
        </section>
    @endif

    @if ($monitoring->certification)
        <section class="mb-4">
            <article class="card">
                <header class="card-header bg-primary text-white">
                    <h2 class="h4">Certification</h2>
                </header>
                <div class="card-body">
                    <p><strong>Certificate Number:</strong> {{ $monitoring->certification->certificate_number }}</p>
                    <p><strong>Issue Date:</strong> {{ $monitoring->certification->issue_date }}</p>
                    <p><strong>Test Results:</strong> {{ $monitoring->certification->test_results }}</p>
                    <div class="text-start my-3">
                        <img src="{{ asset('storage/images/' . $monitoring->certification->image) }}" alt="Certification Image" class="img-fluid rounded" style="height: 200px; width: auto;">
                    </div>
                    <div class="text-start">
                        <img src="{{ asset('storage/qrcodes/' . $monitoring->certification->qrcode)}}" alt="QR Code" class="img-fluid" style="height: 200px; width: auto;">
                    </div>
                </div>
            </article>
        </section>
    @endif

    @if ($monitoring->wasteManagement)
        <section class="mb-4">
            <article class="card">
                <header class="card-header bg-danger text-white">
                    <h2 class="h4">Waste Management</h2>
                </header>
                <div class="card-body">
                    <p><strong>Waste Type:</strong> {{ $monitoring->wasteManagement->waste_type }}</p>
                    <p><strong>Management Method:</strong> {{ $monitoring->wasteManagement->management_method }}</p>
                    <p><strong>Management Results:</strong> {{ $monitoring->wasteManagement->management_results }}</p>
                    <div class="text-start my-3">
                        <img src="{{ asset('storage/images/' . $monitoring->wasteManagement->image) }}" alt="Waste Management Image" class="img-fluid rounded" style="height: 200px; width: auto;">
                    </div>
                    <div class="text-start">
                        <img src="{{ asset('storage/qrcodes/' . $monitoring->wasteManagement->qrcode)}}" alt="QR Code" class="img-fluid" style="height: 200px; width: auto;">
                    </div>
                </div>
            </article>
        </section>
    @endif

    @if ($monitoring->distribution)
        <section class="mb-4">
            <article class="card">
                <header class="card-header bg-secondary text-white">
                    <h2 class="h4">Distribution</h2>
                </header>
                <div class="card-body">
                    <p><strong>Destination:</strong> {{ $monitoring->distribution->destination }}</p>
                    <p><strong>Shipment Date:</strong> {{ $monitoring->distribution->shipment_date }}</p>
                    <p><strong>Tracking Number:</strong> {{ $monitoring->distribution->tracking_number }}</p>
                    <p><strong>Received Date:</strong> {{ $monitoring->distribution->received_date }}</p>
                    <p><strong>Receiver Name:</strong> {{ $monitoring->distribution->receiver_name }}</p>
                    <p><strong>Received Condition:</strong> {{ $monitoring->distribution->received_condition }}</p>
                    <div class="text-start my-3">
                        <img src="{{ asset('storage/images/' . $monitoring->distribution->image) }}" alt="Distribution Image" class="img-fluid rounded" style="height: 200px; width: auto;">
                    </div>
                    <div class="text-start">
                        <img src="{{ asset('storage/qrcodes/' . $monitoring->distribution->qrcode)}}" alt="QR Code" class="img-fluid" style="height: 200px; width: auto;">
                    </div>
                </div>
            </article>
        </section>
    @endif

</div>

</body>
</html>
