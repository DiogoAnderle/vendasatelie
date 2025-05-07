<div class="card">
    <div class="card-header">
        <h3>Relatório de Produtos Mais Vendidos</h3>

        <div class="mb-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <input type="text" class="form-control" id="search" placeholder="Pesquisar Produto..."
                        wire:model.live="search">
                </div>
                <div class="col-auto">
                    <label for="startDate" class="form-label">De:</label>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" id="startDate" wire:mode.livel="startDate">
                </div>
                <div class="col-auto">
                    <label for="endDate" class="form-label">Até:</label>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" id="endDate" wire:model.live="endDate">
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" wire:click="applyFilters">Pesquisar</button>
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
