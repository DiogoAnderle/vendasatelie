<div>
    <x-card cardTitle="Lista de Produtos ({{ $totalRegistros }})">
        <x-slot:cardTools>
            <a class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Cadastrar Produto
            </a>
        </x-slot:cardTools>
        <x-table>
            <x-slot:thead>
                <th>#</th>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preço de Venda</th>
                <th>Estado</th>
                <th colspan=3 width="3%" class="text-center">Ações</th>

            </x-slot:thead>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        <x-image :item="$product"></x-image>
                    </td>
                    <td>{{ $product->name }}</td>
                    <td><a class="badge badge-primary"
                            href="{{ route('categories.show', $product->category->id) }}">{{ $product->category->name }}</a>
                    </td>
                    <td>{!! $product->price !!}</td>
                    <td>{!! $product->activeLabel !!}</td>
                    <td title="Detalhes"><a href="{{ route('products.show', $product) }}"
                            class="btn btn-sm btn-success"><i class="far fa-eye"></i></a>
                    </td>
                    <td title="Editar">
                        <a wire:click="edit({{ $product->id }})"class="btn btn-sm btn-primary">
                            <i class="far fa-edit"></i></a>
                    </td>
                    @if (isAdmin())
                        <td title="Excluir">
                            <a wire:click="$dispatch('delete',{id: {{ $product->id }},name:'{{ $product->name }}', eventName:'destroyProduct'})"
                                class="btn btn-sm btn-danger">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    @endif

                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="8">
                        Sem registros para exibir!</td>

                </tr>
            @endforelse

        </x-table>
        <x-slot:cardFooter>
            {{ $products->links() }}
        </x-slot:cardFooter>

        @include('livewire.product.modal')
    </x-card>


</div>
