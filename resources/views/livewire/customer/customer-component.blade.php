<div>
    <x-card cardTitle="Lista de clientes ({{ $totalRegistros }})">
        <x-slot:cardTools>
            <a href="#" class="btn btn-primary" wire:click='create'>
                <i class="fas fa-plus-circle"></i> Cadastrar Cliente
            </a>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Nome</th>
                <th>Profissão</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Data de Nascimento</th>
                <th colspan="3" width="3%">Ações</th>

            </x-slot>

            @forelse ($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->occupation }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone_number }}</td>
                    @if ($customer->birth_date)
                        <td>{{ date('d/m/Y', strtotime($customer->birth_date)) }}</td>
                    @else
                        <td>Não informado</td>
                    @endif
                    <td>
                        <a href="{{ route('customers.show', $customer) }}"class="btn btn-success btn-sm" title="Ver">
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        <a href="#" wire:click='edit({{ $customer->id }})' class="btn btn-primary btn-sm"
                            title="Editar">
                            <i class="far fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <a wire:click="$dispatch('delete',{id: {{ $customer->id }},name: '{{ $customer->name }}', eventName:'destroyCustomer'})"
                            class="btn btn-danger btn-sm" title="Excluir">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>

            @empty

                <tr class="text-center">
                    <td colspan="7">Sem registros!</td>
                </tr>
            @endforelse

        </x-table>

        <x-slot:cardFooter>
            {{ $customers->links() }}

        </x-slot>

        @include('livewire.customer.modal')
    </x-card>




</div>
