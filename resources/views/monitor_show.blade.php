<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Details</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-1/assets/css/timeline-1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <div class="container mt-5">
        <header class="text-center mb-4">
            <h1>Monitoring Details</h1>
        </header>

        <section class="bsb-timeline-1 py-5 py-xl-8">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-10 col-md-8 col-xl-6">
                        <ul class="timeline">
                            @if ($monitoring->harvest)
                                <li class="timeline-item">
                                    <div class="timeline-body">
                                        <div class="timeline-content">
                                            <div class="card border-0">
                                                <div class="card-body p-0">
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <h5 class="card-subtitle text-secondary mb-1">
                                                                {{ $monitoring->harvest->delivery_date }}
                                                            </h5>
                                                            <h2 class="card-title mb-3"><i class="fas fa-seedling"></i>Harvester </h2>
                                                            <p class="card-text m-0">On {{ $monitoring->harvest->delivery_date }},
                                                                the harvester delivered a batch of
                                                                {{ $monitoring->harvest->quantity }} units of
                                                                {{ $monitoring->harvest->material_type }}, known for its
                                                                {{ $monitoring->harvest->quality }}, with the following delivery
                                                                information: {{ $monitoring->harvest->delivery_info }}.
                                                            </p>
                                                            @if ($monitoring->harvest->image)
                                                                <img src="{{ asset('storage/images/' . $monitoring->harvest->image) }}" alt="Harvest Image" class="img-fluid mt-3">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @if ($craftsmanFactories->isNotEmpty())
                                @foreach ($craftsmanFactories as $factory)
                                    <li class="timeline-item">
                                        <div class="timeline-body">
                                            <div class="timeline-content">
                                                <div class="card border-0">
                                                    <div class="card-body p-0">
                                                        <div class="d-flex align-items-center">
                                                            
                                                            <div>
                                                                <h5 class="card-subtitle text-secondary mb-1">
                                                                    {{ $factory->received_date }}
                                                                </h5>
                                                                <h2 class="card-title mb-3"><i class="fas fa-industry"></i> Factory</h2>
                                                                <p class="card-text m-0"> On {{ $factory->received_date }}, the factory
                                                                    named {{ $factory->factory_name }} located at
                                                                    {{ $factory->factory_address }} started the initial process of
                                                                    {{ $factory->initial_process }}. They produced
                                                                    {{ $factory->semi_finished_quantity }} units
                                                                    with a quality rating of {{ $factory->semi_finished_quality }}.
                                                                </p>
                                                                @if ($factory->image)
                                                                    <img src="{{ asset('storage/images/' . $factory->image) }}" alt="Factory Image" class="img-fluid mt-3">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif

                            @if ($monitoring->craftsman)
                                <li class="timeline-item">
                                    <div class="timeline-body">
                                        <div class="timeline-content">
                                            <div class="card border-0">
                                                <div class="card-body p-0">
                                                    <div class="d-flex align-items-center">
                                                       
                                                        <div>
                                                            <h5 class="card-subtitle text-secondary mb-1">
                                                                {{ $monitoring->craftsman->completion_date }}
                                                            </h5>
                                                            <h2 class="card-title mb-3"> <i class="fas fa-hammer"></i>Craftsman</h2>
                                                            <p class="card-text m-0">On
                                                                {{ $monitoring->craftsman->completion_date }}, the craftsman
                                                                completed the production of
                                                                {{ $monitoring->craftsman->finished_quantity }} units with the
                                                                following production details:
                                                                {{ $monitoring->craftsman->production_details }}.
                                                            </p>
                                                            @if ($monitoring->craftsman->image)
                                                                <img src="{{ asset('storage/images/' . $monitoring->craftsman->image) }}" alt="Craftsman Image" class="img-fluid mt-3">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @if ($monitoring->certification)
                                <li class="timeline-item">
                                    <div class="timeline-body">
                                        <div class="timeline-content">
                                            <div class="card border-0">
                                                <div class="card-body p-0">
                                                    <div class="d-flex align-items-center">
                                                       
                                                        <div>
                                                            <h5 class="card-subtitle text-secondary mb-1">
                                                                {{ $monitoring->certification->issue_date }}
                                                            </h5>
                                                            <h2 class="card-title mb-3"> <i class="fas fa-certificate"></i>Certification</h2>
                                                            <p class="card-text m-0">Certification number
                                                                {{ $monitoring->certification->certificate_number }} was issued on
                                                                {{ $monitoring->certification->issue_date }}, with the following
                                                                test results: {{ $monitoring->certification->test_results }}.
                                                            </p>
                                                            @if ($monitoring->certification->image)
                                                                <img src="{{ asset('storage/images/' . $monitoring->certification->image) }}" alt="Certification Image" class="img-fluid mt-3">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @if ($monitoring->wasteManagement)
                                <li class="timeline-item">
                                    <div class="timeline-body">
                                        <div class="timeline-content">
                                            <div class="card border-0">
                                                <div class="card-body p-0">
                                                    <div class="d-flex align-items-center">
                                                       
                                                        <div>
                                                            <h5 class="card-subtitle text-secondary mb-1">2013</h5>
                                                            <h2 class="card-title mb-3"> <i class="fas fa-recycle"></i>Waste Management</h2>
                                                            <p class="card-text m-0">"The waste type managed was
                                                                {{ $monitoring->wasteManagement->waste_type }}, using the method of
                                                                {{ $monitoring->wasteManagement->management_method }}, which
                                                                resulted in {{ $monitoring->wasteManagement->management_results }}."
                                                            </p>
                                                            @if ($monitoring->wasteManagement->image)
                                                                <img src="{{ asset('storage/images/' . $monitoring->wasteManagement->image) }}" alt="Waste Management Image" class="img-fluid mt-3">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @if ($monitoring->distribution)
                                <li class="timeline-item">
                                    <div class="timeline-body">
                                        <div class="timeline-content">
                                            <div class="card border-0">
                                                <div class="card-body p-0">
                                                    <div class="d-flex align-items-center">
                                                        
                                                        <div>
                                                            <h5 class="card-subtitle text-secondary mb-1">
                                                                {{ $monitoring->distribution->shipment_date }}
                                                            </h5>
                                                            <h2 class="card-title mb-3"><i class="fas fa-truck"></i>Distribution</h2>
                                                            <p class="card-text m-0">The product was shipped to
                                                                {{ $monitoring->distribution->destination }} on
                                                                {{ $monitoring->distribution->shipment_date }} with tracking number
                                                                {{ $monitoring->distribution->tracking_number }}. It was received by
                                                                {{ $monitoring->distribution->receiver_name }} on
                                                                {{ $monitoring->distribution->received_date }} in
                                                                {{ $monitoring->distribution->received_condition }} condition.
                                                            </p>
                                                            @if ($monitoring->distribution->image)
                                                                <img src="{{ asset('storage/images/' . $monitoring->distribution->image) }}" alt="Distribution Image" class="img-fluid mt-3">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                        </ul>

                    </div>
                </div>
            </div>
        </section>

    </div>

</body>

</html>
