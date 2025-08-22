<div class="container py-5">
    <style>
        .search-results {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ddd;
            background: #fff;
            position: absolute;
            width: 100%;
            z-index: 1000;
        }

        .search-results li {
            padding: 8px 12px;
            cursor: pointer;
        }

        .search-results li:hover {
            background: #f8f9fa;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
    <h3 class="mb-4">Create Purchase</h3>
    <a href="{{ route('contacts') }}" class="btn btn-dark mb-3" wire:navigate>Manage Contact</a>

    <!-- Product Search -->
    <div class="mb-3 position-relative">
        <label for="productSearch" class="form-label">Search/Scan Product</label>
        <input type="text" id="productSearch" wire:model.live.debounce.500ms="search" class="form-control"
            placeholder="Type product name or SKU..." autofocus>

        <!-- Search Result List -->
        @if (count($searchItems) > 0)
            <ul class="list-unstyled search-results" id="searchResults">
                @foreach ($searchItems as $item)
                    <li wire:click="addItem({{ $item->id }})">
                        <img src="{{ $item->image }}" alt="" height="20" width="20">
                        {{ $item->sku }} - {{ $item->name }}
                    </li>
                @endforeach
            </ul>

        @endif
    </div>

    <!-- Purchase Table -->
    <form method="POST" wire:submit="addPurchase">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">SL.</th>
                            <th width="10%">SKU</th>
                            <th width="10%">Image</th>
                            <th width="25%">Name</th>
                            <th width="20%">Price</th>
                            <th width="20%">Quantity</th>
                            <th>Subtotal</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="purchaseTable">
                        <!-- Example Row -->
                        @forelse ($items as $key => $item)
                            @include('livewire.partials.purchase-item-row')
                        @empty
                            @include('livewire.partials.no-items', ["colspan" => 8])
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            @if (count($items) > 0)
                                <th colspan="6" class="text-end">Total</th>
                                <th id="totalPrice">{{ $total }}</th>
                                <th></th>
                        </tr>
                        @endif
                    </tfoot>
                </table>
                @if (count($items) > 0)
                    <div class="col-md-12" align="right">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
