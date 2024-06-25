    <x-card cardTitle="Detalhes do Usuário">
        <x-slot:cardTools>
            <a href="{{ route('users') }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left"></i> Voltar</a>
        </x-slot:cardTools>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <x-image :item="$user" size="250" />
                        </div>
                        <h3 class="profile-username text-center"># {{ $user->id }} - {{ $user->name }}</h3>
                        <p class="text-muted text-center">
                            {{ $user->admin ? 'Administrador' : 'Usuário' }}
                        </p>

                        <ul class="list-group mb-3">
                            <li class="list-group-item">
                                <b>E-mail:</b> <a class="float-right text-white">{{ $user->email }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Estado:</b> <a class="float-right text-white">{!! $user->activeLabel !!}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Data de Cadastro:</b> <a
                                    class="float-right text-white">{{ date('d/m/Y', strtotime($user->created_at)) }}</a>
                            </li>

                        </ul>
                    </div>

                </div>

            </div>
            <div class="col-md-8">
                <table class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fatura</th>
                            <th>Total</th>
                            <th>Produtos</th>
                            <th>Itens</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sales as $sale)
                            <tr>
                                <td>FV-{{ $sale->id }}</td>
                                <td>
                                    <a href="{{ route('sales.invoice', $sale) }}" target="_blank"
                                        class="btn bg-navy btn-sm" title="Imprimir Fatura">
                                        <i class="far fa-file-pdf text-white"></i>
                                    </a>
                                </td>
                                <td>{{ currencyBRLFormat($sale->net_value) }}</td>
                                <td><span class="badge badge-pill badge-primary">{{ $sale->items->count() }}</span>
                                </td>
                                <td>
                                    <span
                                        class="badge badge-pill badge-primary">{{ $sale->items->sum('pivot.quantity') }}

                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-primary">Ver
                                        venda</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">Sem registros.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                {{ $sales->links() }}
            </div>
        </div>
    </x-card>
