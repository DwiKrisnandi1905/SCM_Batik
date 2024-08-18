@extends('layout.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Monitoring Details</h1>

    @if ($monitoring->harvest)
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="h5">Harvest</h2>
            </div>
            <div class="card-body">
                <p><strong>Material Type:</strong> {{ $monitoring->harvest->material_type }}</p>
                <p><strong>Quantity:</strong> {{ $monitoring->harvest->quantity }}</p>
                <p><strong>Quality:</strong> {{ $monitoring->harvest->quality }}</p>
                <p><strong>Delivery Info:</strong> {{ $monitoring->harvest->delivery_info }}</p>
                <p><strong>Delivery Date:</strong> {{ $monitoring->harvest->delivery_date }}</p>
                <p><strong>Image:</strong> <img src="{{ asset('storage/images/' . $monitoring->harvest->image) }}" alt="Harvest Image" class="img-fluid" style="height: 100px; width: auto;"></p>
                <p><strong>QR Code:</strong> <img src="{{ asset('storage/qrcodes/'. $monitoring->harvest->qrcode )}}" alt="QR Code" class="img-fluid" style="height: 100px; width: auto;"></p>
            </div>
        </div>
    @endif

    @if ($monitoring->factory)
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="h5">Factory</h2>
            </div>
            <div class="card-body">
                <p><strong>Received Date:</strong> {{ $monitoring->factory->received_date }}</p>
                <p><strong>Initial Process:</strong> {{ $monitoring->factory->initial_process }}</p>
                <p><strong>Semi-Finished Quantity:</strong> {{ $monitoring->factory->semi_finished_quantity }}</p>
                <p><strong>Semi-Finished Quality:</strong> {{ $monitoring->factory->semi_finished_quality }}</p>
                <p><strong>Factory Name:</strong> {{ $monitoring->factory->factory_name }}</p>
                <p><strong>Factory Address:</strong> {{ $monitoring->factory->factory_address }}</p>
                <p><strong>Image:</strong> <img src="{{ asset('storage/images/' . $monitoring->factory->image) }}" alt="Factory Image" class="img-fluid" style="height: 100px; width: auto;"></p>
                <p><strong>QR Code:</strong> <img src="{{ asset('storage/qrcodes/'. $monitoring->factory->qrcode )}}" alt="QR Code" class="img-fluid" style="height: 100px; width: auto;"></p>
            </div>
        </div>
    @endif

    @if ($monitoring->wasteManagement)
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="h5">Waste Management</h2>
            </div>
            <div class="card-body">
                <p><strong>Waste Type:</strong> {{ $monitoring->wasteManagement->waste_type }}</p>
                <p><strong>Management Method:</strong> {{ $monitoring->wasteManagement->management_method }}</p>
                <p><strong>Management Results:</strong> {{ $monitoring->wasteManagement->management_results }}</p>
                <p><strong>Image:</strong> <img src="{{ asset('storage/images/' . $monitoring->wasteManagement->image) }}" alt="Waste Management Image" class="img-fluid" style="height: 100px; width: auto;"></p>
                <p><strong>QR Code:</strong> <img src="{{ asset('storage/qrcodes/'. $monitoring->wasteManagement->qrcode )}}" alt="QR Code" class="img-fluid" style="height: 100px; width: auto;"></p>
            </div>
        </div>
    @endif

    @if ($monitoring->certification)
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="h5">Certification</h2>
            </div>
            <div class="card-body">
                <p><strong>Certificate Number:</strong> {{ $monitoring->certification->certificate_number }}</p>
                <p><strong>Issue Date:</strong> {{ $monitoring->certification->issue_date }}</p>
                <p><strong>Test Results:</strong> {{ $monitoring->certification->test_results }}</p>
                <p><strong>Image:</strong> <img src="{{ asset('storage/images/' . $monitoring->certification->image) }}" alt="Certification Image" class="img-fluid" style="height: 100px; width: auto;"></p>
                <p><strong>QR Code:</strong> <img src="{{ asset('storage/qrcodes/'. $monitoring->certification->qrcode )}}" alt="QR Code" class="img-fluid" style="height: 100px; width: auto;"></p>
            </div>
        </div>
    @endif

    @if ($monitoring->craftsman)
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="h5">Craftsman</h2>
            </div>
            <div class="card-body">
                <p><strong>Production Details:</strong> {{ $monitoring->craftsman->production_details }}</p>
                <p><strong>Finished Quantity:</strong> {{ $monitoring->craftsman->finished_quantity }}</p>
                <p><strong>Completion Date:</strong> {{ $monitoring->craftsman->completion_date }}</p>
                <p><strong>Image:</strong> <img src="{{ asset('storage/images/' . $monitoring->craftsman->image) }}" alt="Craftsman Image" class="img-fluid" style="height: 100px; width: auto;"></p>
                <p><strong>QR Code:</strong> <img src="{{ asset('storage/qrcodes/'. $monitoring->craftsman->qrcode )}}" alt="QR Code" class="img-fluid" style="height: 100px; width: auto;"></p>
            </div>
        </div>
    @endif

    @if ($monitoring->distribution)
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="h5">Distribution</h2>
            </div>
            <div class="card-body">
                <p><strong>Destination:</strong> {{ $monitoring->distribution->destination }}</p>
                <p><strong>Shipment Date:</strong> {{ $monitoring->distribution->shipment_date }}</p>
                <p><strong>Tracking Number:</strong> {{ $monitoring->distribution->tracking_number }}</p>
                <p><strong>Received Date:</strong> {{ $monitoring->distribution->received_date }}</p>
                <p><strong>Receiver Name:</strong> {{ $monitoring->distribution->receiver_name }}</p>
                <p><strong>Received Condition:</strong> {{ $monitoring->distribution->received_condition }}</p>
                <p><strong>Image:</strong> <img src="{{ asset('storage/images/' . $monitoring->distribution->image) }}" alt="Distribution Image" class="img-fluid" style="height: 100px; width: auto;"></p>
                <p><strong>QR Code:</strong> <img src="{{ asset('storage/qrcodes/'. $monitoring->distribution->qrcode )}}" alt="QR Code" class="img-fluid" style="height: 100px; width: auto;"></p>
            </div>
        </div>
    @endif
</div>
@endsection
