<tr>
    <th scope="row">{{ $product->id }}</th>
    <td>
        <x-image :item="$product" size="50" />

    </td>
    <td>{{ $product->name }}</td>
    <td>{!! $product->price !!}</td>
    <td>{!! $stockLabel !!}</td>
    <td>

        <button wire:click="addProduct({{ $product->id }})" class="btn btn-primary btn-sm" wire:loading.attr='disabled'
            wire:target='addProduct' {{ $stockLabel <= '0' ? 'disabled' : '' }} title="Incluir">
            <i class="fas fa-plus-circle"></i>
        </button>

    </td>

</tr>
