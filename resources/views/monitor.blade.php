<h1>Monitoring Details</h1>

<h2>Monitoring</h2>
<p>ID: {{ $monitoring->id }}</p>
<p>Harvest ID: {{ $monitoring->harvest_id }}</p>
<p>Factory ID: {{ $monitoring->factory_id }}</p>
<p>Craftsman ID: {{ $monitoring->craftsman_id }}</p>
<p>Certification ID: {{ $monitoring->certification_id }}</p>
<p>Waste ID: {{ $monitoring->waste_id }}</p>
<p>Distribution ID: {{ $monitoring->distribution_id }}</p>
<p>Status: {{ $monitoring->status }}</p>
<p>Last Updated: {{ $monitoring->last_updated }}</p>
<p>Created At: {{ $monitoring->created_at }}</p>
<p>Updated At: {{ $monitoring->updated_at }}</p>

@if ($monitoring->harvest)
    <h2>Harvest</h2>
    <p>ID: {{ $monitoring->harvest->id }}</p>
    <p>User ID: {{ $monitoring->harvest->user_id }}</p>
    <p>Material Type: {{ $monitoring->harvest->material_type }}</p>
    <p>Quantity: {{ $monitoring->harvest->quantity }}</p>
    <p>Quality: {{ $monitoring->harvest->quality }}</p>
    <p>Delivery Info: {{ $monitoring->harvest->delivery_info }}</p>
    <p>Delivery Date: {{ $monitoring->harvest->delivery_date }}</p>
    <p>Image: <img src="{{ asset('path/to/images/' . $monitoring->harvest->image) }}" alt="Harvest Image"></p>
    <p>QR Code: <img src="{{ asset('path/to/qrcodes/' . $monitoring->harvest->qrcode) }}" alt="QR Code"></p>
@endif
