<div>
    <x-card cardTitle="Dados da Loja">
        <x-slot:cardTools>
            <a class="btn btn-primary" wire:click='edit'>
                <i class="fas fa-edit"></i> Editar
            </a>
        </x-slot>

        <div class="table-responsive">
            <table class="table table-hover table-striped text-center">
                <thead>
                    <th>ID</th>
                    <th>
                        <i class="fas fa-image"></i>
                    </th>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Slogan</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Endereço</th>
                    <th>Cidade</th>

                    <thead>
                    <tbody>
                        <tr>
                            <td>{{ $shop->id }}</td>
                            <td>
                                <x-image :item="$shop" />
                            </td>
                            <td>{{ $shop->name }}</td>
                            <td>{{ $shop->cnpj }}</td>
                            <td>{{ $shop->slogan }}</td>
                            <td>{{ $shop->email }}</td>
                            <td>{{ $shop->phone_number }}</td>
                            <td>{{ $shop->address }}</td>
                            <td>{{ $shop->city }}</td>
                        </tr>
                    </tbody>
            </table>
        </div>

        <x-slot:cardFooter>
        </x-slot>



        {{-- MODAL EDITAR --}}

        @include('livewire.shop.modal')

    </x-card>

</div>
