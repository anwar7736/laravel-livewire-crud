<tr wire:key="{{ $item['id'] }}">
    <td>{{ $loop->iteration }}</td>
    <td>{{ $item['sku'] }}</td>
    <td><img src="{{ $item['image'] }}" class="product-img" alt="Product"></td>
    <td>{{ $item['name'] }}</td>
    <td>
        <input type="number" class="form-control form-control text-center" min="0"
                wire:model.lazy="items.{{ $key }}.price">
                @error("items.$key.price")
                <div class="text-danger">
                    {{$message}}
                </div>
                @enderror
        </td>
    <td>
        <input type="number" class="form-control form-control-sm text-center" min="0"
            wire:model.lazy="items.{{ $key }}.quantity">
                @error("items.$key.quantity")
                <div class="text-danger">
                    {{$message}}
                </div>
                @enderror
    </td>
    <td>{{ $item['sub_total'] }}</td>
    <td><button type="button" wire:click="removeItem({{ $key }})"
            class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button></td>
</tr>