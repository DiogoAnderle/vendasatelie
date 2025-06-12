<div>
    <div class="card">
        <div class="card-header">
            <h3>Relatório de Produtos Mais Vendidos</h3>
            <div class="mb-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="searchBestProducts"
                            placeholder="Pesquisar Produto..." wire:model.live="searchBestProducts">
                    </div>
                    <div class="col-auto">
                        <label for="startDateBestProducts" class="form-label">De:</label>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="startDateBestProducts"
                            wire:mode.livel="startDateBestProducts">
                    </div>
                    <div class="col-auto">
                        <label for="endDateBestProducts" class="form-label">Até:</label>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="endDateBestProducts"
                            wire:model.live="endDateBestProducts">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary" wire:click="applyFilters">Pesquisar</button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('reports.export.pdf') }}" class="btn btn-danger me-2" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="card-body">
            <div class="card">
                <div class="card-head">
                    <div class="float-left">
                        <label for="perPage" class="me-2">Itens por página:</label>
                        <select wire:model.live="perPage" id="perPage" class="form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Imagem</th>
                                    <th>Nome</th>
                                    <th>Preço Venda</th>
                                    <th>Quantidade Vendida</th>
                                    <th>Total Vendido</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bestSellingProducts as $product)
                                    <tr>
                                        <td>{{ $product->product_id }}</td>
                                        <td>
                                            <img src="{{ asset($product->image) }}" width="50px" class="img-fluid rounded">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ currencyBRLFormat($product->price) }}</td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $product->total_quantity }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ currencyBRLFormat($product->price * $product->total_quantity) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Nenhum produto encontrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    {{ $bestSellingProducts->links() }}
                </div>
            </div>
        </div>

    </div>


    <div class="card">
        <div class="card-header">
            <h3 class="text-xl font-bold mt-10 mb-4">Vendas sem Nota Fiscal</h3>

            <div class="mb-3">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="startDateProductsWithoutInvoice" class="form-label">De:</label>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="startDateProductsWithoutInvoice"
                            wire:model.live="startDateProductsWithoutInvoice">
                    </div>
                    <div class="col-auto">
                        <label for="endDateProductsWithoutInvoice" class="form-label">Até:</label>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control" id="endDateProductsWithoutInvoice"
                            wire:model.live="endDateProductsWithoutInvoice">
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('reports.exportSalesWithoutInvoice.pdf', [
    'startDateProductsWithoutInvoice' => $startDateProductsWithoutInvoice,
    'endDateProductsWithoutInvoice' => $endDateProductsWithoutInvoice
]) }}" class="btn btn-danger me-2" target="_blank">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="card-body">
            <div class="card">
                <div class="card-head">
                    <div class="float-left">
                        <label for="perPageProductsWithoutInvoice" class="me-2">Itens por página:</label>
                        <select wire:model.live="perPageProductsWithoutInvoice" id="perPageProductsWithoutInvoice"
                            class="form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-auto float-right">
                        <div class="">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1">
                                    <i class="fas fa-money-bill-wave"></i>
                                </span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Vendido (Sem Nota)</span>
                                    <span class="info-box-number">
                                        R$ {{ number_format($totalSalesWithoutInvoice, 2, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th>ID</th>
                                    <th>Data</th>
                                    <th>Total</th>
                                    <th>Desconto</th>
                                    <th>Valor Líquido</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($salesWithoutInvoice as $sale)
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}
                                        </td>
                                        <td>R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                                        <td>R$ {{ number_format($sale->addition_discount, 2, ',', '.') }}
                                        </td>
                                        <td>R$ {{ number_format($sale->net_value, 2, ',', '.') }}</td>
                                        <td>{{ ucfirst($sale->status) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">Nenhuma venda encontrada
                                            para o período.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4">
                    {{ $salesWithoutInvoice->links() }}
                </div>
            </div>
        </div>

    </div>
</div>