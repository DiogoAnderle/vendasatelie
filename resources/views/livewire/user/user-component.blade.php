<div>
    <x-card cardTitle="Lista de Usuarios ({{ $this->totalRegistros }})">
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Cadastrar Usuário
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Imagem</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Perfil</th>
                <th>Estado</th>
                <th colspan=3 width="3%" class="text-center">Ações</th>

            </x-slot>

            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><x-image :item="$user"></x-image></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->admin ? 'Administrator' : 'Usuário' }}</td>
                    <td>{!! $user->activeLabel !!}</td>
                    <td>
                        <a href=" {{ route('users.show', $user) }}" class="btn btn-success btn-sm" title="Ver">
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        <a href="#" wire:click='edit({{ $user->id }})' class="btn btn-primary btn-sm"
                            title="Editar">
                            <i class="far fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <a wire:click="$dispatch('delete',{id: {{ $user->id }}, eventName:'destroyUser'})"
                            class="btn btn-danger btn-sm" title="Eliminar">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>

            @empty

                <tr class="text-center">
                    <td colspan="7">Sem registros para mostrar!</td>
                </tr>
            @endforelse

        </x-table>

        <x-slot:cardFooter>
            {{ $users->links() }}

        </x-slot>
        @include('livewire.user.modal')
    </x-card>
</div>
