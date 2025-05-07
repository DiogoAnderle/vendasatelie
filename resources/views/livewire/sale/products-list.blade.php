<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-tshirt"></i> Produtos ({{ $totalRegistros }})</h3>
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
                <livewire:sale.product-row :product="$product" :wire:key="$product->id" />
            @empty
                <tr>
                    <td colspan="10">Sem Registros!</td>
                </tr>
            @endforelse

        </x-table>

        {{ $products->links() }}


    </div>



</div>
