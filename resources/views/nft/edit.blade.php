@extends('admin.layout.app')

@section('content')
<div class="container">
    <h1 class="my-4">Edit NFT Config</h1>

    <form action="{{ route('update-nft', $nftConfig->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="fromAddress" class="form-label">From Address</label>
            <input type="text" name="fromAddress" class="form-control"
                value="{{ old('fromAddress', $nftConfig->fromAddress) }}" placeholder="Enter From Address">
        </div>

        <div class="mb-3">
            <label for="contractAddress" class="form-label">Contract Address</label>
            <input type="text" name="contractAddress" class="form-control"
                value="{{ old('contractAddress', $nftConfig->contractAddress) }}" placeholder="Enter Contract Address">
        </div>

        <div class="mb-3">
            <label for="abi" class="form-label">ABI</label>
            <textarea name="abi" class="form-control" rows="5" placeholder="Enter ABI">{{ old('abi', $nftConfig->abi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update NFT Config</button>
    </form>
</div>
@endsection
