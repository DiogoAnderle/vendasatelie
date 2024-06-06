<div>
    <x-card cardTitle="Lista de Categorias ({{ $this->totalRegistros }})">
        <x-slot:cardTools>
            <a class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Cadastrar Categoria
            </a>
        </x-slot:cardTools>
        <x-table>
            <x-slot:thead>
                <th>#</th>
                <th>Nome</th>
                <th colspan=3 width="3%" class="text-center">Ações</th>

            </x-slot:thead>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td title="Detalhes"><a href="{{ route('categories.show', $category) }}"
                            class="btn btn-sm btn-success"><i class="far fa-eye"></i></a>
                    </td>
                    <td title="Editar">
                        <a wire:click="edit({{ $category->id }})"class="btn btn-sm btn-primary">
                            <i class="far fa-edit"></i></a>
                    </td>
                    <td title="Excluir">
                        <a wire:click="$dispatch('delete',{id: {{ $category->id }}, eventName:'destroyCategory'})"
                            class="btn btn-sm btn-danger">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>

                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="5">
                        Sem registros para exibir!</td>

                </tr>
            @endforelse

        </x-table>
        <x-slot:cardFooter>
            {{ $categories->links() }}
        </x-slot:cardFooter>

        <x-modal modalId="modalCategory" modalTitle="{{ $Id == 0 ? 'Criar Categoria' : 'Editar Categoria' }}">
            <form wire:submit={{ $Id == 0 ? 'store' : "update($Id)" }}>
                <div class="form-row">
                    <div class="form-group col mb-3">

                        <label for="name" class="form-label">Categoria:</label>
                        <input wire:model='name' type="text" class="form-control"id="name"
                            placeholder="Nome da categoria">
                        @error('name')
                            <div class="alert alert-danger w-100 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary float-right">{{ $Id == 0 ? 'Salvar' : 'Editar' }}</button>
            </form>
        </x-modal>
    </x-card>

</div>
