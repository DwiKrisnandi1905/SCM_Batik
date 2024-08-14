
<div class="container">
    <h1>Harvest Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $harvest->material_type }}</h5>
            <p class="card-text">Quantity: {{ $harvest->quantity }}</p>
            <p class="card-text">Quality: {{ $harvest->quality }}</p>
            <p class="card-text">Delivery Info: {{ $harvest->delivery_info }}</p>
            <p class="card-text">Delivery Date: {{ $harvest->delivery_date }}</p>
            <p class="card-text">NFT Token ID: {{ $harvest->nft_token_id }}</p>
            <img src="{{ asset('storage/images/' . $harvest->image) }}" alt="Harvest Image" class="img-fluid">
        </div>
    </div>
</div>
