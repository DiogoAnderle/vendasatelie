<div>
    <x-card cardTitle="Lista de vendas ({{ $this->totalRegistros }})">
        <x-slot:cardTools>
            <div class="d-flex align-items-center">
                <span class="badge badge-info" style="font-size: 1.1rem">Total
                    {{ currencyBRLFormat($totalVendas) }}</span>
                <div class="mx-3">
                    {{-- {{ $dateStart . ' - ' . $dateEnd }} --}}
                    <button id="daterange-btn" class="btn btn-default" wire:ignore>
                        <i class="far fa-calendar-alt"></i>
                        <span>D/M/A - D/M/A</span>
                    </button>
                </div>
                <a href="{{ route('sales.create') }}" class="btn btn-primary" wire:click='create'>
                    <i class="fas fa-cart-plus"></i> Criar venta
                </a>
            </div>
        </x-slot>

        <x-table>
            <x-slot:thead>
                <th>ID</th>
                <th>Nome</th>
                <th>Total</th>
                <th>Acrésc./Desc.</th>
                <th>Valor Liq.</th>
                <th>Qtd. Prod.</th>
                <th>Qtd. Items</th>
                <th>Data</th>
                <th colspan="4" width="3%">Ações</th>


            </x-slot>

            @forelse ($sales as $sale)
                <tr>
                    <td>
                        <span class="badge badge-primary">FV-{{ $sale->id }}</span>
                    </td>
                    <td>{{ $sale->customer->name }}</td>
                    <td>
                        <span class="badge badge-secondary">{{ currencyBRLFormat($sale->total) }}</span>
                    </td>
                    <td>
                        <span class="badge badge-warning">{{ currencyBRLFormat($sale->addition_discount) }}</span>
                    </td>
                    <td>
                        <span class="badge badge-success">{{ currencyBRLFormat($sale->net_value) }}</span>
                    </td>

                    <td>
                        <span class="badge badge-pill bg-orange">{{ $sale->items->count() }}</span>
                    </td>

                    <td>
                        <span class="badge badge-pill bg-orange">{{ $sale->items->sum('pivot.quantity') }}</span>
                    </td>

                    <td>{{ date('d/m/Y', strtotime($sale->sale_date)) }}</td>
                    <td>
                        <a href="{{ route('sales.invoice', $sale) }}" target="_blank" class="btn bg-navy btn-sm"
                            title="Imprimir Fatura">
                            <i class="far fa-file-pdf text-white"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-success btn-sm" title="Ver">
                            <i class="far fa-eye"></i>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-primary btn-sm" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <a wire:click="$dispatch('delete',{id: {{ $sale->id }}, eventName:'destroySale'})"
                            class="btn btn-danger btn-sm" title="Eliminar">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>

            @empty

                <tr class="text-center">
                    <td colspan="9">Sem registros!</td>
                </tr>
            @endforelse

        </x-table>

        <x-slot:cardFooter>
            {{ $sales->links() }}

        </x-slot>
    </x-card>

    @section('styles')
        <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    @endsection
    @section('scripts')
        <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
        <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script>
            $('#daterange-btn').daterangepicker({

                    ranges: {
                        'Padrão': [moment().startOf('year'), moment()],
                        'Hoje': [moment(), moment()],
                        'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                        'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                        'Este mês': [moment().startOf('month'), moment().endOf('month')],
                        'Mês Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                            .endOf(
                                'month')
                        ]
                    },
                    locale: {
                        "applyLabel": 'Confirmar',
                        "cancelLabel": 'Cancelar',
                        "daysOfWeek": [
                            "Dom",
                            "Seg",
                            "Ter",
                            "Qua",
                            "Qui",
                            "Sex",
                            "Sab"
                        ],
                        "monthNames": [
                            "Jan",
                            "Fev",
                            "Mar",
                            "Abr",
                            "Mai",
                            "Jun",
                            "Jul",
                            "Ago",
                            "Set",
                            "Out",
                            "Nov",
                            "Dez"
                        ],

                    },
                    startDate: moment().startOf('year'),
                    endDate: moment()
                },
                function(start, end) {
                    startDate = start.format('YYYY-MM-DD');
                    endDate = end.format('YYYY-MM-DD');
                    $('#daterange-btn span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));

                    Livewire.dispatch('setDates', {
                        startDate: startDate,
                        endDate: endDate,
                    })
                }

            );
        </script>
    @endsection


</div>
