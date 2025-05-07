<x-card title="Ver venta">
    <x-slot:cardTools>

        <a href="{{ route('sales.list') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>


    </x-slot>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Cliente</h5>
                <div class="card-body">
                    {{-- card dados cliente --}}
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center" style="font-size: 4rem">
                                <i class="fas fa-user-circle"></i>
                            </div>

                            <h3 class="profile-username text-center my-3">
                                {{ $sale->customer->name }}
                            </h3>

                            <ul class="list-group  mb-3">
                                <li class="list-group-item">
                                    <b>Telefone</b>
                                    <a class="float-right text-white userdata">
                                        {{ $sale->customer->phone_number }}
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b>
                                    <a class="float-right text-white userdata">
                                        {{ $sale->customer->email }}
                                    </a>
                                </li>

                                <li class="list-group-item">
                                    <b>Profissão</b> <a class="float-right text-white userdata">
                                        {{ $sale->customer->occupation }}
                                    </a>
                                </li>

                                <li class="list-group-item">
                                    <b>Cadastro</b>
                                    <a class="float-right text-white userdata">
                                        {{ date('d/m/Y', strtotime($sale->customer->created_at)) }}
                                    </a>
                                </li>
                            </ul>

                            <a href="{{ route('customers.show', $sale->customer) }}"
                                class="btn btn-primary btn-block"><b>Ver</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    {{-- end card datos cliente --}}
                </div>
            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Factura: <b>FV-{{ $sale->id }}</b> 
                       
                     
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('sales.invoice', $sale) }}" target="_blank" title="Imprimir Fatura">
                            <span class="btn btn-sm btn-danger mr-2">
                                <i class="far fa-file-pdf text-white "></i>
                                Fatura
                            </span>
                        </a>    
                        
                        <a href="{{ route('sales.receipt', $sale) }}" target="_blank" title="Imprimir Recibo">
                            <span class="btn btn-sm btn-primary mr-2">
                                <i class="far fa-file-pdf text-white "></i>
                                Recibo
                            </span>
                        </a>     
                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-warning btn-sm text-white" title="Editar">
                            <i class="far fa-edit"></i>Editar
                        </a>       
                        <i class="fas fa-tshirt" title="Número produtos"></i>
                        <span class="badge badge-pill badge-primary mr-2">
                            {{ $sale->items->count() }}
                        </span>
                        <i class="fas fa-shopping-basket" title="Número items"></i>
                        <span class="badge badge-pill badge-primary mr-2">
                            {{ $sale->items->sum('pivot.quantity') }}
                        </span>
                        <i class="fas fa-clock" title="Data e hora da venda"></i>
                        {{ date('d/m/Y h:i:s', strtotime($sale->created_at)) }}

                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm table-striped text-center">

                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"><i class="fas fa-image"></i></th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Nota Fiscal</th>
                                    <th scope="col">Produto</th>
                                    <th scope="col">Preço venda</th>
                                    <th scope="col" width="15%">Qtd</th>
                                    <th scope="col">Sub total</th>

                                </tr>

                            </thead>
                            <tbody>
                                @forelse ($sale->items as $product)
                                    <tr>
                                        <th scope="row">{{ ++$loop->index }}</th>
                                        <td>
                                            <img src="{{ asset($product->image) }}" width="40"
                                                class="img-fluid rounded">

                                        </td>
                                        @if($sale->status == 0)
                                        <td>
                                            <a wire:click="$dispatch('finished',{id: {{ $sale->id }}, eventName:'finishSale'})"
                                                class="btn" title="Concluir Pedido">
                                                {!! $sale->statusLabel !!}
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <span> {!! $sale->statusLabel !!}</span>
                                        </td>
                                    
                                    @endif
                                        <td>
                                            <span> {!! $sale->invoiceLabel !!}</span>
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ currencyBRLFormat($product->price) }}</td>
                                        <td>
                                            <span class="badge badge-pill badge-primary">
                                                {{ $product->quantity }}
                                            </span>
                                        </td>

                                        <td>{{ currencyBRLFormat($product->quantity * $product->price) }}</td>


                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="10">Sin Registros</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td colspan="4"></td>
                                    <td>
                                        <h5>Total:</h5>
                                    </td>
                                    <td>
                                        <h5>
                                            <span class="badge badge-pill badge-secondary">
                                                {{ currencyBRLFormat($sale->net_value) }}
                                            </span>
                                        </h5>
                                    </td>

                                </tr>
                                <tr>

                                    <td colspan="7">
                                        <strong>Total por extenso:</strong>
                                        {{ numbersInFull($sale->net_value) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Vendedor</h3>
                    <div class="card-tools">

                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-hover table-sm table-striped text-center">

                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"><i class="fas fa-image"></i></th>
                                <th scope="col">Nome</th>
                                <th scope="col">Perfil</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ação</th>

                            </tr>

                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">{{ $sale->user->id }}</th>
                                <td>
                                    <x-image :item="$sale->user" />


                                </td>
                                <td>{{ $sale->user->name }}</td>
                                <td>{{ $sale->user->admin ? 'Administrador' : 'Vendedor' }}</td>

                                <td>{{ $sale->user->email }}</td>
                                <td>
                                    <a href="{{ route('users.show', $sale->user->id) }}"
                                        class="btn btn-success btn-xs">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </td>


                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->

        </div>
    </div>


    <x-slot:cardFooter>

    </x-slot>

</x-card>
