<div class="container">
    <h1>Edit NFT Config</h1>

    <form action="{{ route('update-nft', $nftConfig->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="fromAddress">From Address</label>
            <input type="text" name="fromAddress" class="form-control"
                value="{{ old('fromAddress', $nftConfig->fromAddress) }}">
        </div>

        <div class="form-group">
            <label for="contractAddress">Contract Address</label>
            <input type="text" name="contractAddress" class="form-control"
                value="{{ old('contractAddress', $nftConfig->contractAddress) }}">
        </div>

        <div class="form-group">
            <label for="abi">ABI</label>
            <textarea name="abi" class="form-control">{{ old('abi', $nftConfig->abi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update NFT Config</button>
    </form>