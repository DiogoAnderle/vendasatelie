<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-tshirt"></i> Produtos ({{ $totalRegistros }})</h3>
        <div class="float-right text-dark">
            @livewire('sale.product-sale')
        </div>
    </div>

    <div class="card-body">

        <x-table>

            <x-slot:thead>
                <th scope="col">#</th>
                <th scope="col"><i class="fas fa-image"></i></th>
                <th scope="col">Nome</th>
                <th scope="col">Preço.vd</th>
                <th scope="col">Ação</th>
            </x-slot>

            @forelse ($products as $product)
                <tr>
                    <th scope="row">{{ $product->id }}</th>
                    <td>
                        <x-image :item="$product" size="50" />
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{!! $product->price !!}</td>
                    <td>
                        <button wire:click="addProduct({{ $product->id }})" class="btn btn-primary btn-sm"
                            wire:loading.attr='disabled' wire:target='addProduct' title="Incluir"
                            {{ $this->isProductInCart($product->id) ? 'disabled' : '' }}>
                            <i class="fas fa-plus-circle"></i>
                        </button>

                        <a wire:click="editProduct({{ $product->id }})"class="btn btn-sm btn-warning">
                            <i class="far fa-edit"></i></a>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10">Sem Registros!</td>
                </tr>
            @endforelse

        </x-table>

        {{ $products->links() }}

    </div>

</div>
